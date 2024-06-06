# Logging

We log just the basic things such as route access, login failure or action on data.
We are using the given logger interface `Monolog` and two self created channels named `security` and `action`.
You can view the logs in your backend at `/var/log`.

## Types of log

- `security.log` contains all relevant logs about route access, invalid token and permission violation.
- `action.log` contains all logs about creating, manipulating or deleting data.

## Configuration

All configurations can be found in the `monolog.yaml` config which is located in `/config/packages/`.

