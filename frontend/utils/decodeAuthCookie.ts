import { JwtAuthPayload } from "~/types/auth"
import { jwtDecode } from "jwt-decode/build/esm"

/**
 * Decode the auth cookie and return the payload or null
 */
export default function (): JwtAuthPayload | null {
  const token = useCookie("BearerToken")
  return token.value ? jwtDecode<JwtAuthPayload>(token.value) : null
}
