import { jwtDecode } from "jwt-decode"
import type { JwtAuthPayload } from "~/types/auth"

/**
 * Decode the auth cookie and return the payload or null
 */
function decodeAuthCookie(): JwtAuthPayload | null {
  const token = useCookie("BearerToken")
  return token.value ? jwtDecode<JwtAuthPayload>(token.value) : null
}

/**
 * Middleware to check if the user is authenticated
 * and redirect to the login page if not
 * @param to - The route to navigate to
 * @param from - The route the user is coming from
 */
export default defineNuxtRouteMiddleware((to, from) => {
  const cookie = decodeAuthCookie()
  const authenticated = cookie?.authenticated

  if (!authenticated && to.path !== "/login") {
    return navigateTo("/login")
  }

  if (authenticated && to.path === "/login") {
    return navigateTo("/")
  }
})
