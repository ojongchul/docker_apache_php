# 관련 자료
* [기존 readme.md](/readme.old.md)
* [db](/ddl.sql)

# API 설명

모든 입력 항목에 대해 비정상적인 접근은 없는 private api라고 가정함.

## 회원 데이터 생성(회원 가입) API
: 회원 정보를 입력받아 DB에 추가
sample url : http://133.186.247.134/index.php/User/signUp
* method : POST
* parameter 
	* email(string, required)
	* name(string, required)
	* password(string, required)
	* phone(string, required)
	* affiliate(string, optional)
	* event(boolean, optional)
* return
	* result : 1 or -1
	* msg : 성공 or 오류 메시지

## 회원 데이터 수정(비밀번호 정보 수정) API
: 기존 비밀번호와 변경 비밀번호를 입력받아 확인 후 DB 업데이트

* sample url : http://133.186.247.134/index.php/User/editPassword
* method : POST
* parameter 
	* email
	* password_old
	* password_new
*  return
	* result : 1 or -1
	* msg : 성공 or 오류 메시지

## 회원 데이터 수정(비밀번호 외 정보 수정) API
: 비밀번호를 제외한 다른 정보(이름, 전화번호) 업데이트
 sample url : http://133.186.247.134/index.php/User/editAccount
* method : POST
* parameter 
	* email
	* password
	* name
	* phone
*  return
	* result : 1 or -1
	* msg : 성공 or 오류 메시지

## 회원 데이터 삭제 API
: 계정 정보를 삭제 테이블로 이동 후 삭제
 sample url : http://133.186.247.134/index.php/User/removeAccount
* method : POST
* parameter 
	* email
	* password
*  return
	* result : 1 or -1
	* msg : 성공 or 오류 메시지

## 하나의 회원 데이터 출력 API
: 계정 idx를 입력받아 상세 데이터 출력
 sample url : http://133.186.247.134/index.php/User/getUserInfo
* method : POST
* parameter 
	* idx
*  return
	* result : 1 or -1
	* msg : 성공 or 오류 메시지

## 여러 회원 데이터 출력(페이지를 나눠 출력) API
: 계정 리스트 출력
 sample url : http://133.186.247.134/index.php/User/getUserList
* method : POST
* parameter 
	* pagano
	* pagelength
*  return
	* result : 1 or -1
	* msg : 성공 or 오류 메시지
