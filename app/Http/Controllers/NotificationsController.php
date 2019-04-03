<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller {
    /**
     * Gets all of the user's notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all() {
        return response()->json(Auth::user()->notifications, 200);
    }

    /**
     * Reads a specific notifications.
     *
     * @param integer $id - Notification ID.
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($id) {
        Auth::user()->unreadNotifications->where("id", $id)->markAsRead();

        return response()->json(["success" => [
            "message" => "Notification read",
        ]], 200);
    }

    /**
     * Reads all of the user's notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function readAll() {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(["success" => [
            "message" => "Notifications read",
        ]], 200);
    }

    /**
     * Deletes a specific notifications.
     *
     * @param integer $id - Notification ID.
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        Auth::user()->notifications()->find($id)->delete();

        return response()->json(["success" => [
            "message" => "Notification deleted",
        ]], 200);
    }

    /**
     * Deletes all of the user's notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll() {
        Auth::user()->notifications()->delete();

        return response()->json(["success" => [
            "message" => "Notifications deleted",
        ]], 200);
    }
}
