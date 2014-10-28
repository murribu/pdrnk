<?php

use League\OAuth2\Server\Storage\SessionInterface;

class SessionStorage implements SessionInterface
{
    /**
     * Create a new session
     *
     * @param  string $clientId  The client ID
     * @param  string $ownerType The type of the session owner (e.g. "user")
     * @param  string $ownerId   The ID of the session owner (e.g. "123")
     * @return int               The session ID
     */
    public function createSession($clientId, $ownerType, $ownerId)
    {
        $session = Session::create([
            'client_id'  => $clientId,
            'owner_type' => $ownerType,
            'owner_id'   => $ownerId,
        ]);

        return $session->id;
    }

    /**
     * Delete a session
     *
     * @param  string $clientId  The client ID
     * @param  string $ownerType The type of the session owner (e.g. "user")
     * @param  string $ownerId   The ID of the session owner (e.g. "123")
     * @return void
     */
    public function deleteSession($clientId, $ownerType, $ownerId)
    {
        Session::where('client_id', $clientId)
            ->where('owner_type', $ownerType)
            ->where('owner_id', $ownerId)
            ->delete();
    }

    /**
     * Associate a redirect URI with a session
     *
     * @param  int    $sessionId   The session ID
     * @param  string $redirectUri The redirect URI
     * @return void
     */
    public function associateRedirectUri($sessionId, $redirectUri)
    {
        SessionRedirect::create([
            'session_id'   => $sessionId,
            'redirect_uri' => $redirectUri,
        ]);
    }

    /**
     * Associate an access token with a session
     *
     * @param  int    $sessionId   The session ID
     * @param  string $accessToken The access token
     * @param  int    $expireTime  Unix timestamp of the access token expiry time
     * @return void
     */
    public function associateAccessToken($sessionId, $accessToken, $expireTime)
    {
        SessionAccessToken::create([
            'session_id'           => $sessionId,
            'access_token'         => $accessToken,
            'access_token_expires' => $expireTime,
        ]);
    }

    /**
     * Associate a refresh token with a session
     *
     * @param  int    $accessTokenId The access token ID
     * @param  string $refreshToken  The refresh token
     * @param  int    $expireTime    Unix timestamp of the refresh token expiry time
     * @param  string $clientId      The client ID
     * @return void
     */
    public function associateRefreshToken($accessTokenId, $refreshToken, $expireTime, $clientId)
    {
        SessionRefreshToken::create([
            'session_access_token_id' => $accessTokenId,
            'refresh_token'           => $refreshToken,
            'refresh_token_expires'   => $expireTime,
            'client_id'               => $clientId,
        ]);
    }

    /**
     * Assocate an authorization code with a session
     *
     * @param  int    $sessionId  The session ID
     * @param  string $authCode   The authorization code
     * @param  int    $expireTime Unix timestamp of the access token expiry time
     * @return int                The auth code ID
     */
    public function associateAuthCode($sessionId, $authCode, $expireTime)
    {
        $code = SessionAuthcode::create([
            'session_id'        => $sessionId,
            'auth_code'         => $authCode,
            'auth_code_expires' => $expireTime,
        ]);

        return $code->id;
    }

    /**
     * Remove an associated authorization token from a session
     *
     * @param  int    $sessionId   The session ID
     * @return void
     */
    public function removeAuthCode($sessionId)
    {
        SessionAuthcode::where('session_id', $sessionId)
            ->delete();
    }

    /**
     * Validate an authorization code
     *
     * @param  string     $clientId    The client ID
     * @param  string     $redirectUri The redirect URI
     * @param  string     $authCode    The authorization code
     * @return array|bool              False if invalid or array as above
     */
    public function validateAuthCode($clientId, $redirectUri, $authCode)
    {
        $code = SessionAuthcode::join('oauth_session_authcodes', 'oauth_session_authcodes.session_id', '=', 'oauth_sessions.id')
            ->join('oauth_session_redirects', 'oauth_session_redirects.session_id', '=', 'oauth_sessions.id ')
            ->select('oauth_sessions.id AS session_id', 'oauth_session_authcodes.id AS authcode_id')
            ->where('oauth_sessions.client_id', $clientId)
            ->where('oauth_session_authcodes.auth_code', $authCode)
            ->where('oauth_session_redirects.redirect_uri', $redirectUri)
            ->first();

        return is_null($code) ? false : $code->toArray();
    }

    /**
     * Validate an access token
     *
     * @param  string     $accessToken The access token
     * @return array|bool              False if invalid or an array as above
     */
    public function validateAccessToken($accessToken)
    {
        $token = SessionAccessToken::join('oauth_sessions', 'oauth_sessions.id', '=', 'oauth_session_access_tokens.session_id')
            ->select('oauth_session_access_tokens.session_id', 'oauth_sessions.client_id', 'oauth_sessions.owner_id', 'oauth_sessions.owner_type')
            ->where('oauth_session_access_tokens.access_token', $accessToken)
            ->where('oauth_session_access_tokens.access_token_expires', '>=', time())
            ->first();

        return is_null($token) ? false : $token->toArray();
    }

    /**
     * Removes a refresh token
     *
     * @param  string $refreshToken The refresh token to be removed
     * @return void
     */
    public function removeRefreshToken($refreshToken)
    {
        SessionRefreshToken::where('refresh_token', $refreshToken)
            ->delete();
    }

    /**
     * Validate a refresh token
     *
     * @param  string   $refreshToken The access token
     * @param  string   $clientId     The client ID
     * @return int|bool               The ID of the access token the refresh token is linked to (or false if invalid)
     */
    public function validateRefreshToken($refreshToken, $clientId)
    {
        $tokenId = SessionRefreshToken::select('session_access_token_id')
            ->where('refresh_token', $refreshToken)
            ->where('client_id', $clientId)
            ->where('refresh_token_expires', time())
            ->first();

        return is_null($token) ? false : $tokenId;
    }

    /**
     * Get an access token by ID
     *
     * @param  int    $accessTokenId The access token ID
     * @return array
     */
    public function getAccessToken($accessTokenId)
    {
        $token = SessionAccessToken::where('id', $accessTokenId)
            ->first();

        return is_null($token) ? false : $token->toArray();
    }

    /**
     * Associate scopes with an auth code (bound to the session)
     *
     * @param  int $authCodeId The auth code ID
     * @param  int $scopeId    The scope ID
     * @return void
     */
    public function associateAuthCodeScope($authCodeId, $scopeId)
    {
        SessionAuthcodeScope::create([
            'oauth_session_authcode_id' => $authCodeId,
            'scope_id'                  => $scopeId,
        ]);
    }

    /**
     * Get the scopes associated with an auth code
     *
     * @param  int   $oauthSessionAuthCodeId The session ID
     * @return array
     */
    public function getAuthCodeScopes($oauthSessionAuthCodeId)
    {
        $scopes = SessionAuthcodeScope::select('scope_id')
            ->where('oauth_session_authcode_id', $oauthSessionAuthCodeId)
            ->get();

        return $scopes;
    }

    /**
     * Associate a scope with an access token
     *
     * @param  int    $accessTokenId The ID of the access token
     * @param  int    $scopeId       The ID of the scope
     * @return void
     */
    public function associateScope($accessTokenId, $scopeId)
    {
        SessionTokenScope::create([
            'session_access_token_id' => $accessTokenId,
            'scope_id'                => $scopeId,
        ]);
    }

    /**
     * Get all associated scopes for an access token
     *
     * @param  string $accessToken The access token
     * @return array
     */
    public function getScopes($accessToken)
    {
        $scopes = SessionTokenScope::join('oauth_session_access_tokens', 'oauth_session_access_tokens.id', '=', 'oauth_session_token_scopes.session_access_token_id')
            ->join('oauth_scopes', 'oauth_scopes.id', '=', 'oauth_session_token_scopes.scope_id')
            ->select('oauth_scopes.*')
            ->where('oauth_session_token_scopes.access_token', $accessToken)
            ->get();

        return $scopes;
    }
}
?>