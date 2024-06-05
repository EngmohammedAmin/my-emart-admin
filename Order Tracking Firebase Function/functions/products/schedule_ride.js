const functions = require('firebase-functions');
const admin = require ("firebase-admin");

// admin.initializeApp();
const firestore = admin.firestore();

const kDistanceRadiusForDispatchInMiles = 50


exports.scheduleRide = functions.pubsub.schedule('* * * * *').onRun(async (context) => {

    var minimumDepositToRideAccept = await getMinimumDepositToRideAccept();
    if(minimumDepositToRideAccept == undefined){
        minimumDepositToRideAccept = 0;
    }else{
        minimumDepositToRideAccept = parseInt(minimumDepositToRideAccept);
    }
    console.log('minimumDepositToRideAccept',minimumDepositToRideAccept);

	console.log('currentTimestamp',admin.firestore.Timestamp.now());
    
	const querySnapshot = await firestore.collection('rides').where('scheduleDateTime', '<=', admin.firestore.Timestamp.now()).get();
    
    if(querySnapshot.size > 0) {

        querySnapshot.forEach(function(doc) {

            const orderData = doc.data();

            if (!orderData) {
                console.log("No order data");
                return;
            }

            if (orderData.status === "Order Cancelled") {
                console.log("Order #" + orderData.id + " was cancelled.")
                return null;
            }

            if (orderData.status === "Order Placed" || orderData.status === "Order Accepted" || orderData.status === "Driver Rejected") {
            // the vendor accepted the order, so we need to find an available driver
            console.log("Finding a driver for order #" + orderData.id)

            const rejectedByDrivers = orderData.rejectedByDrivers ? orderData.rejectedByDrivers : []

            return firestore
                .collection("users")
                .where('role', '==', "driver")
                .where('serviceType', '==', "cab-service")
                .where('sectionId', '==', orderData.sectionId)
                .where('vehicleId', '==', orderData.vehicleId)
                .where('isActive', '==', true)
                .where('wallet_amount', '>=', minimumDepositToRideAccept)
                .get()
                .then(snapshot => {
                    var found = false
                    snapshot.forEach(doc => {
                        if (!found) {
                            // We simply assign the first available driver who's within a reasonable distance from the vendor and who did not reject the order and who is not delivering already
                            const driver = doc.data();
                           

                            if(driver.rideType == "both" || driver.rideType == orderData.rideType){
                                console.log(driver)
                                if (driver.location
                                && rejectedByDrivers.indexOf(driver.id) === -1
                                && (driver.inProgressOrderID === undefined || driver.inProgressOrderID === null)
                                && (driver.ordercabRequestData === undefined || driver.ordercabRequestData === null)) {
                                /*const vendor = orderData.vendor*/
                                if (orderData.sourceLocation) {
                                    const distance = distanceRadiusride(driver.location.latitude, driver.location.longitude, orderData.sourceLocation.latitude, orderData.sourceLocation.longitude)
                                    if (distance < kDistanceRadiusForDispatchInMiles) {
                                        found = true
                                        // We update the order status

                                        firestore
                                            .collection('rides')
                                            .doc(orderData.id)
                                            .update({
                                            status: "Driver Pending"
                                            });

                                        // We send the order to the driver, by appending ordercabRequestData to the driver's user model in the users table
                                        firestore
                                            .collection('users')
                                            .doc(driver.id)
                                            .update({
                                                ordercabRequestData: orderData,
                                            });
                                        console.log("Order sent to driver #" + driver.id + " for order #" + orderData.id + " with distance at " + distance)
                                        }
                                    }
                                }
                            }
                            
                        }
                    })
                    if (!found) {
                        // We did not find an available driver
                        console.log("Could not find an available driver for order #" + orderData.id)
                    }
                    return null
                })
                .catch(error => {
                    console.log(error)
                })
            }
        });
    }else{
        console.log("No results found");
    }
    return null
});

const distanceRadiusride = (lat1, lon1, lat2, lon2) => {
	if ((lat1 === lat2) && (lon1 === lon2)) {
		return 0;
	}
	else {
		var radlat1 = Math.PI * lat1/180;
		var radlat2 = Math.PI * lat2/180;
		var theta = lon1-lon2;
		var radtheta = Math.PI * theta/180;
		var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
		if (dist > 1) {
			dist = 1;
		}
		dist = Math.acos(dist);
		dist = dist * 180/Math.PI;
		dist = dist * 60 * 1.1515;
		return dist;
	}
}

async function getMinimumDepositToRideAccept(){
    var snapshot =  await firestore.collection("settings").doc('DriverNearBy').get();
    return snapshot.data().minimumDepositToRideAccept;
}