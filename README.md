# YARP - Yet Another Rhythm Platform

Platform for YARG Players track progress, news or anything related to the game.

## Technologies

| Name    | Version |
|---------|---------|
| PHP     | 8.2     |
| Laravel | 10      |
| Inertia | 1       |
| React   | 18      |
| MySQL   | 8.0     |


## Development

* [ ] Bands
  * [x] Create a Band
  * [ ] Define roles for the band
* [x] Auth
  * [x] Register with e-mail
  * [x] Register with SSO (Github, Discord and Twitter)
  * [x] 2FA
* [ ] Profile
  * [x] Private Profile (Authenticated)
  * [ ] Public Profile (Guest)


## Contributors

* Daniel Reis (danielhe4rt) - Back-end Developer && He4rt Developers Leader
* Joao Victor Visoná (mc poze do código) - Front End Developer && He4rt Developers Member
* Gustavo Pantoja (Pantotone) - Front end Developer

## Tables

* table: instruments
    * id: int
    * name: string
* table: difficulties
    * id:
    * name:
* table: users
    * id: id
    * username: string
    * email: string
    * password: string
    * locale: string (nullable)
    * instrument: int
* table: articles
    * id:
    * type_id: string (news, update, announcements)
    * title: string
    * author_id: int
    * banner_url: string (nullable)
    * published_at: datetime

