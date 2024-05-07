import { jwtDecode } from "jwt-decode"

function decodedCookie(): any {
  const token = useCookie("BearerToken")

  if (typeof token.value === "string") return jwtDecode(token.value)
  else return null
}
export default defineNuxtRouteMiddleware((to, from) => {
  const cookie = decodedCookie()
  if (cookie !== null) {
    if (cookie.authenticated) {
      if (to.path === "/login") {
        return navigateTo("/")
      } else return navigateTo(to)
    } else {
      return navigateTo("/login")
    }
  }
})
