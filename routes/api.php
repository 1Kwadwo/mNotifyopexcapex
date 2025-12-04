<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/webpush/vapid-public-key', function () {
        return response(config('webpush.vapid.public_key'));
    });

    Route::post('/webpush/subscribe', function (Request $request) {
        auth()->user()->updatePushSubscription(
            $request->input('endpoint'),
            $request->input('keys.p256dh'),
            $request->input('keys.auth'),
            $request->input('contentEncoding')
        );

        return response()->json(['success' => true]);
    });

    Route::post('/webpush/unsubscribe', function (Request $request) {
        auth()->user()->deletePushSubscription($request->input('endpoint'));
        return response()->json(['success' => true]);
    });
});
