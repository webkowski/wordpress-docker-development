wordpress-docker-development

wordpress-docker-development is based on _tw https://underscoretw.com/, (C) 2021-2023 Greg Sullivan

======

## Installation

1. Create `.env` from `.env.dist`
2. Run `docker-compose up`
3. Run `yarn install && yarn dev` in this folder
4. Activate this theme in WordPress
5. Put sql dump file into `/db`

## Development

1. Run `yarn watch`

See the complete [development documentation](https://underscoretw.com/docs/tailwind-plugins-npm-commands/) for more details.

## Deployment

1. Run `yarn bundle`
2. Upload the resulting zip file to your site using the “Upload Theme” button on the “Add Themes” administration page

Or [deploy with the tool of your choice](https://underscoretw.com/docs/deployment/#h-other-deployment-options)!
