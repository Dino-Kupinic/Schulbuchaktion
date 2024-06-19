import decodeAuthCookie from "~/utils/decodeAuthCookie"

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
