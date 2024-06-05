const functions = require('firebase-functions');
const admin = require('firebase-admin');

// admin.initializeApp();

const triggers = require('./triggers')
const delivery = require('./products/delivery')
const parcel_delivery = require('./products/parcel_delivery')
const schedule_ride = require('./products/schedule_ride')

// Production triggers
exports.propagateUserProfileUpdates = triggers.propagateUserProfileUpdates

exports.deliveryDispatch = delivery.dispatch

exports.parcelDispatch = parcel_delivery.dispatch

exports.scheduleRide = schedule_ride.scheduleRide

// // Create and Deploy Your First Cloud Functions
// // https://firebase.google.com/docs/functions/write-firebase-functions
//
// exports.helloWorld = functions.https.onRequest((request, response) => {
//  response.send("Hello from Firebase!");
// });

exports.deleteUser = functions.https.onCall(async (data, context) => {
    try {
        // Potentially verify that the user calling the CF has the right to delete users
        await admin.auth().deleteUser(data.uid);
        return { result: 'user successfully deleted'};
    } catch (error) {
        throw new functionsGlobal.https.HttpsError('failed-precondition','The function must be called while authenticated.', 'hello');   // See https://firebase.google.com/docs/functions/callable#handle_errors
    }

});