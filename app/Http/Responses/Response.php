<?php
    namespace App\Http\Responses;

    class Response {

        const STATUS_CREATED = 201;
        const STATUS_OK = 200;
        const STATUS_BAD_REQUEST = 400;
        const STATUS_NO_CONTENT = 204;
        const STATUS_NOT_FOUND = 404;

        //.....


        public static function error($message) {

            return [
                "status" => "error",
                "message" => $message
            ];
        }

        public static function success($message) {

            return [
                "status" => "success",
                "message" => $message
            ];
        }
    }
