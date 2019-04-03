<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller {
    public function all() {
        return response()->json(Auth::user()->notifications, 200);
    }

    public function read($id) {
        Auth::user()->unreadNotifications->where("id", $id)->markAsRead();

        return response()->json(["success" => [
            "message" => "Notification read",
        ]], 200);
    }

    public function readAll() {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(["success" => [
            "message" => "Notifications read",
        ]], 200);
    }

    public function delete($id) {
        Auth::user()->notifications->where("id", $id)->delete();

        return response()->json(["success" => [
            "message" => "Notification deleted",
        ]], 200);
    }

    public function deleteAll() {
        Auth::user()->notifications()->delete();

        return response()->json(["success" => [
            "message" => "Notifications deleted",
        ]], 200);
    }
}
