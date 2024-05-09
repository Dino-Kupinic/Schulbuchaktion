/**
 * API response interface
 * @interface APIResponse
 * @property {boolean} success - API request status
 * @property {unknown | unknown[]} data - API response data
 * @property {string} errorMessage - API response error message
 */
export interface APIResponse<T = unknown> {
  success: boolean
  data?: T
  errorMessage?: string
}

/**
 * API response interface for array
 * @interface APIResponseArray
 * @extends APIResponse
 * @property {T[]} data - API response data
 */
export interface APIResponseArray<T> extends APIResponse<T[]> {}

/**
 * API response interface for object
 * @interface APIResponseObject
 * @extends APIResponse
 * @property {T} data - API response data
 */
export interface APIResponseObject<T> extends APIResponse<T> {}
