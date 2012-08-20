var frisby = require('frisby'),
    HOST = 'http://yourhostname.com';

frisby
	.create('Test getting a user\'s profile.')
	.get(HOST + '/user/profile/1')
	.expectStatus(200)
	.expectJSON({
		id: '1',
		username: 'Test Profile',
		email: 'testprofile@somedomain.com',
	})
.toss();