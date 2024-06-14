import type { JwtAuthPayload } from "~/types/auth"
import { jwtDecode } from "jwt-decode"

/**
 * Decode the auth cookie and return the payload or null
 */
export default function (): JwtAuthPayload | null {
  const token = useCookie("BearerToken")
  return token.value ? jwtDecode<JwtAuthPayload>(token.value) : null
}
