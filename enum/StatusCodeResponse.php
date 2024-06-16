<?php
    namespace laptopstore\enum;
    /**
     * các status code có trong chương trình
     */
    final class StatusCodeResponse{
        public const OK = 200;//lấy dữ liệu thành công
        public const Created = 201;//thêm, update thành công
        public const NonAuthoritativeInformation = 203;//validate thất bại
        public const BadRequest = 400;//yêu cầu không hợp lệ
        public const Unauthorized = 401;//unauthorized không có quyền truy cập || chưa có accessToken
        public const LoginTimeout = 440;//access token hết hạn header('HTTP/1.1 440 Login Timeout'); 
        public const NotFound = 404;//unauthorized không có quyền truy cập
        public const UnsupportedMediaType = 415;//định dạng file không được hỗ trợ
        public const InternalServerError = 500;//hệ thống bị lỗi 
    }
?>