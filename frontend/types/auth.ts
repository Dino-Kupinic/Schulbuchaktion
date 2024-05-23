import type { APIPrimitiveResponse } from "~/types/response"
import type { JwtPayload } from "jwt-decode"

/**
 * Type for LoginResponse
 * @type LoginResponse
 * @property {string} token - JWT token
 */
export type LoginResponse = APIPrimitiveResponse<"token", string>

/**
 * JWT payload interface
 * @interface JwtPayload
 * @property {boolean} authenticated - JWT authentication status
 */
export interface JwtAuthPayload extends JwtPayload {
  authenticated: boolean
}
