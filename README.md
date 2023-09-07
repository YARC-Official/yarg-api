# YARG Platform

## Tables

* table: instruments
  * id: int
  * name: string

* table: difficulties
  * id:
  * name:

* table: users
  * id:
  * username: string
  * email: string
  * password: string
  * locale: string (nullable)
  * instrument: int

* table: users_oauths
  * id: int
  * user_id: int
  * provider: // discord - github
  * provider_id: int
  * provider_username: string

* table: user_oauth_tokens
  * id
  * oauth_id:
  * access_token:
  * refresh_token:
  * expires_at:



* table: articles
  * id
  * type_id: string (news, update, announcements)
  * title: string
  * author_id: int
  * banner_url: string (nullable)
  * published_at: datetime

ACL top
https://spatie.be/docs/laravel-permission/v5/introduction[
