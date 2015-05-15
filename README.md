# appota_game_test
Appota game test (backend)

## Host
http://192.168.3.167/appota_game_test

##API
1. Check Appota User
	- Endpoint: `check_appota_user.php`
	- Method: `POST`
	- Params:
		- `appota_access_token`: Appota access token after login success
		- `appota_user_id`: Appota user id after login success
		- `appota_user_name` : Appota user name
	- Response:
		- `error_code` : 0 or 1
		- `message` : If `error_code` == 1
		- `list_server` : If `error_code` == 0, list available game server
2. Get Game User
	- Endpoint: `login_game.php`
	- Method: `GET`
	- Params:
		- `action` = `get_game_user`
		- `server_id`: Server id after user choosing
		- `appota_user_id`: Appota user id
		- `appota_user_name` : Appota user name
	- Response:
		- `error_code` : 0 or 1
		- User info if `error_code` == 0:
			- `game_user_name`
			- `id` - game user id
			- `level`
			- `server_id`
			- `gold`
			- `diamond`
			- `is_vip`
		- `message` if `error_code` == 1 and require create new game user (call create game user function)

3. Create Game User
	- Endpoint: `login_game.php`
	- Method: `POST`
	- Params:
		- `action` = `create_game_user`
		- `server_id`: Server id after user choosing
		- `appota_user_id`: Appota user id
		- `appota_user_name` : Appota user name
	- Response:
		- `error_code` : 0 or 1
		- User info if `error_code` == 0:
			- `game_user_name`
			- `id` - game user id
			- `level`
			- `server_id`
			- `gold`
			- `diamond`
			- `is_vip`
		- `message` if `error_code` == 1
		
		

		

