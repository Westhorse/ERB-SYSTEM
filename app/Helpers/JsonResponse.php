<?php


namespace App\Helpers;


class JsonResponse
{
    const MSG_ADDED_SUCCESSFULLY = 'responses.msg_added_successfully';
    const MSG_UPDATED_SUCCESSFULLY = "responses.msg_updated_successfully";
    const MSG_DELETED_SUCCESSFULLY = "responses.msg_deleted_successfully";
    const MSG_NOT_ALLOWED = "responses.msg_not_allowed";
    const MSG_NOT_AUTHORIZED = "responses.msg_not_authorized";
    const MSG_NOT_AUTHENTICATED = "responses.msg_not_authenticated";
    const MSG_USER_NOT_ENABLED = "responses.msg_user_not_enabled";
    const MSG_NOT_FOUND = "responses.msg_not_found";
    const MSG_USER_NOT_FOUND = "responses.msg_user_not_found";
    const MSG_EMAIL_NOT_VERIFIED = "your email not verified";
    const MSG_WRONG_PASSWORD = "responses.msg_wrong_password";
    const MSG_SUCCESS = "responses.msg_success";
    const MSG_FAILED = "responses.msg_failed";
    const MSG_LOGIN_SUCCESSFULLY = "responses.msg_login_successfully";
    const MSG_LOGIN_FAILED = "responses.msg_login_failed";
    const MSG_LOGOUT_SUCCESSFULLY = "responses.msg_logout_successfully";
    const MSG_CANNOT_DELETED = "responses.msg_cannot_deleted";
    const MSG_BAD_REQUEST = "responses.msg_bad_request";
    const MSG_PROPER_HEADER = "responses.msg_add_proper_header";

    /**
     * @param null $content
     * @return \Illuminate\Http\JsonResponse
     */
    public static function respondSuccess($message, $content = null, $status = 200)
    {
        return response()->json([
            'result' => trans(self::MSG_SUCCESS),
            'data' => $content,
            'message' => $message,
            'status' => $status
        ]);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function respondError($message, $status = 500)
    {
        return response()->json([
            'result' => trans(self::MSG_FAILED),
            'data' => null,
            'message' => $message,
            'status' => $status
        ]);
    }

    public static function downloadFile($url)
    {
        return response()->download(public_path('storage/' . $url));
    }

    public static function uploadFile($url)
    {
    }

    public static function success()
    {
        return ['result' => trans(self::MSG_SUCCESS), 'message' => trans(self::MSG_SUCCESS), 'status' => 200];
    }

    public static function savedSuccessfully()
    {
        return ['result' => trans(self::MSG_SUCCESS), 'message' => trans(self::MSG_ADDED_SUCCESSFULLY), 'status' => 200];
    }

    public static function updatedSuccessfully()
    {
        return ['result' => trans(self::MSG_SUCCESS), 'message' => trans(self::MSG_UPDATED_SUCCESSFULLY), 'status' => 200];
    }
}
