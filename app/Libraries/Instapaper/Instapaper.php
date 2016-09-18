<?php

namespace App\Libraries\Instapaper;

class Instapaper {

	public $client;

	public function login() {
		/** 1. Create a new InstapaperOAuth object using the consumer token.
		 **    The Instapaper API allows developers access to data in Instapaper.
		 **    You will need to get an OAuth consumer token from Instapaper before
		 **    you can access the API.
		 **
		 **        Request Access: http://www.instapaper.com/main/request_oauth_consumer_token
		 **
		 **    After your request is granted, you will receive an OAuth consumer key
		 **    and an OAuth consumer secret. Enter those values here:
		 */
		$consumer_key = env('INSTAPAPER_CONSUMER_KEY');
		$consumer_secret = env('INSTAPAPER_CONSUMER_SECRET');
		$instapaper = new InstapaperOAuth($consumer_key,$consumer_secret);

		/** 2. The Instapaper API uses xAuth. You ask your users for a username and password,
		 *     and Instapaper will give you back a token you can use to make future requests.
		 *     You would normally ask your users for this information when you first connect
		 *     to their account, but for this sample application you should simply enter a
		 *     username and password here:
		 */
		$x_auth_username = env('X_AUTH_USERNAME');
		$x_auth_password = env('X_AUTH_PASSWORD');

		/** 3. Pass this username and password to Instapaper; Instapaper will pass back a token
		 **    you can use for future requests to that user's account. In a real application,
		 **    you would need to save these two pieces of data so that you could use them for
		 **    future requests. You need to perform this step once for each user whose
		 **    Instapaper's account you want to access.
		 ** */
		$token = $instapaper->get_access_token($x_auth_username,$x_auth_password);
		$oauth_token = $token["oauth_token"];
		$oauth_token_secret = $token["oauth_token_secret"];

		/** 4. Once you have that information, use it to re-create the InstapaperOAuth object. */
		$this->client = new InstapaperOAuth($consumer_key,$consumer_secret,$oauth_token,$oauth_token_secret);

		return $this->client;
	}

	public function is_user_active() {
		// verify that the user has an active subscription
		$result = ( $this->client->verify_credentials() );
		$user = $result[0];

		if ($user->subscription_is_active != 1) {
			die('You must have an Instapaper subscription to use the features of the Instapaper API required by this application.');
		}
	}

	public function request($route, $parameters = []) {
		$parameters['format'] = 'json';
		return $this->client->post($this->client->host . $route, $parameters);
	}
}
