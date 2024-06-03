import { jwtDecode } from "jwt-decode"

function decodedCookie(): any {
  const token = useCookie("BearerToken")

  if (typeof token.value === "string") return jwtDecode(token.value)
  else return null
}
export default defineNuxtRouteMiddleware((to, from) => {
  // const cookie = decodedCookie()
  // if (cookie !== null) {
  //   console.log(cookie.authenticated)
  //   if (cookie.authenticated && to.path === "/login") {
  //     return navigateTo("/")
  //   } else if (!cookie.authenticated) {
  //     return navigateTo("/login")
  //   }
  // } else if (to.path !== "/login") {
  //   console.log("cookie is null")
  //   return navigateTo("/login")
  // }
})
