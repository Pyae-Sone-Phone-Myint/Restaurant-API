# RESTAURANT API

## API Reference

#### Login (Post)

```https
    http://127.0.0.1:8000/api/v1/login
```

| Arguments | Type   | Validation   | Description     |
| :-------- | :----- | :----------- | :-------------- |
| email     | string | **Required** | admin@gmail.com |
| password  | string | **Required** | asdffdsa        |

## Roles

#### Roles (Get)

```https
    http://127.0.0.1:8000/api/v1/user/roles
```

## Profile

### Profile Lists

#### User Lists (Get)

-   Admin can only see user lists.

```https
    http://127.0.0.1:8000/api/v1/user/lists
```

#### Your Profile (Get)

```https
    http://127.0.0.1:8000/api/v1/user/profile
```

#### User Profile (Get)

-   Admin can only check user profile.

```https
    http://127.0.0.1:8000/api/v1/user/profile/{id}
```

### Manage Profile

#### Edit User Profile (Put)

-   Admin can only edit user profile.

```https
    http://127.0.0.1:8000/api/v1/user/edit-profile/{id}
```

| Arguments     | Type   | Validation   | Description     |
| :------------ | :----- | :----------- | :-------------- |
| name          | string | **Required** | example name    |
| phone         | string | **Required** | 098754621       |
| date_of_birth | date   | **Required** | 1998-04-25      |
| address       | string | **Required** | example address |
| user_photo    | string | **Required** | photo url       |

#### Edit Your Profile (Put)

```https
    http://127.0.0.1:8000/api/v1/user/edit-profile
```

| Arguments     | Type   | Validation   | Description     |
| :------------ | :----- | :----------- | :-------------- |
| name          | string | **Required** | example name    |
| phone         | string | **Required** | 098754621       |
| date_of_birth | date   | **Required** | 1998-04-25      |
| address       | string | **Required** | example address |
| user_photo    | string | **Nullable** | photo url       |

#### Create User Account (Post)

-   Admin only can create user account.

```https
    http://127.0.0.1:8000/api/v1/user/create
```

| Arguments             | Type    | Validation   | Description               |
| :-------------------- | :------ | :----------- | :------------------------ |
| name                  | string  | **Required** | example name              |
| phone                 | string  | **Required** | 098754621                 |
| date_of_birth         | date    | **Required** | 1998-04-25                |
| gender                | string  | **Required** | male or female            |
| email                 | string  | **Required** | example@gmail.com         |
| password              | string  | **Required** | password                  |
| password_confirmation | string  | **Required** | password                  |
| role_id               | integer | **Required** | role_id (from role table) |
| address               | string  | **Required** | example address           |
| user_photo            | string  | **Nullable** | photo url                 |

#### Ban User (Post)

-   Admin only can ban user.

```https
    http://127.0.0.1:8000/api/v1/user/{id}/ban
```

#### Un-ban User (Post)

-   Admin only can un-ban user.

```https
    http://127.0.0.1:8000/api/v1/user/{id}/un-ban
```

### Logout

#### Logout (Post)

```https
    http://127.0.0.1:8000/api/v1/user/logout
```

#### Logout All Device (Post)

```https
    http://127.0.0.1:8000/api/v1/user/logout-all
```

#### Password Change (Post)

```https
    http://127.0.0.1:8000/api/v1/user/change-password
```

| Arguments             | Type   | Validation   | Description      |
| :-------------------- | :----- | :----------- | :--------------- |
| current_password      | string | **Required** | current password |
| password              | string | **Required** | new password     |
| password_confirmation | string | **Required** | new password     |
