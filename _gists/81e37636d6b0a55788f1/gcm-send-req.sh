curl -X "POST" "https://android.googleapis.com/gcm/send" \
	-H "Authorization: key=[INSERT_PRIVATE_SERVER_KEY_HERE]" \
	-H "Content-Type: application/json" \
	-d "{\"registration_ids\":[\"USERS_SUBSCRIPTION_ID\"],\"data\":{\"foo\":\"bar\"}}"
