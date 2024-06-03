import { jwtDecode } from "jwt-decode"
import type { JwtAuthPayload } from "~/types/auth"

function decodeAuthCookie() {
  const token = useCookie("BearerToken")
  return token.value ? jwtDecode<JwtAuthPayload>(token.value) : null
}

export default defineNuxtRouteMiddleware((to, from) => {
  const cookie = decodeAuthCookie()
  const authenticated = cookie?.authenticated

  console.log(authenticated)

  if (!authenticated && to.path !== "/login") {
    return navigateTo("/login")
  }

  if (authenticated && to.path === "/login") {
    return navigateTo("/")
  }
})
