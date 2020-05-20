# php_test_api

API 테스트 방법


회원가입 
http://localhost/rest/web/member_add

회원조회
http://localhost/rest/web/member_view

회원목록
http://localhost/rest/web/member_list

단일 회원 주문 목록


/* table 생성 쿼리  */
// member table 생성
/* CREATE TABLE `member` (
	`idx` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'idx',
	`kname` VARCHAR(20) NOT NULL COMMENT '이름' COLLATE 'utf8mb4_unicode_ci',
	`nickname` VARCHAR(30) NOT NULL COMMENT '별명' COLLATE 'utf8mb4_unicode_ci',
	`upw` VARCHAR(150) NOT NULL COMMENT '비밀번호' COLLATE 'utf8mb4_unicode_ci',
	`mobile` VARCHAR(20) NOT NULL COMMENT '전화번호' COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(100) NOT NULL COMMENT '이메일' COLLATE 'utf8mb4_unicode_ci',
	`gender` CHAR(1) NULL DEFAULT NULL COMMENT '성별' COLLATE 'utf8mb4_unicode_ci',
	`createdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
	PRIMARY KEY (`idx`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
; */


// order table 생성
/* CREATE TABLE `order` (
	`idx` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'idx',
	`member_idx` INT(11) NOT NULL,
	`order_num` VARCHAR(12) NOT NULL COMMENT '주문번호' COLLATE 'utf8mb4_unicode_ci',
	`name` VARCHAR(100) NOT NULL COMMENT '제품명' COLLATE 'utf8mb4_unicode_ci',
	`createdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '결제일',
	PRIMARY KEY (`idx`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
; */




