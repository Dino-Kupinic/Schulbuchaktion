# nuxt

FROM node:lts-alpine as build-stage

WORKDIR /app

RUN npm install -g pnpm

COPY package.json pnpm-lock.yaml ./

RUN pnpm install

COPY . .

RUN pnpm run generate

# nginx

FROM nginx:alpine

COPY --from=build-stage /app/.output/public /usr/share/nginx/html

COPY nginx/nginx.conf /etc/nginx/nginx.conf

EXPOSE 3000

CMD ["nginx", "-g", "daemon off;"]

