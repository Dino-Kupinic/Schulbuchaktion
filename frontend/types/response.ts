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
  error?: string
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

/**
 * API response interface for paginated data
 * @interface APIResponsePaginated
 * @extends APIResponse
 * @property {boolean} success - API request status
 * @property {T[]} data.books - API response data
 * @property {number} data.total - Total number of data
 * @property {number} data.pages - Total number of pages
 * @property {number} data.perPage - Number of data per page
 * @property {number} data.page - Current page
 * @property {string} error - API response error message
 */
export interface APIResponsePaginated<T> extends APIResponse<object> {
  success: boolean
  data?: {
    books: T[]
    total: number
    pages: number
    perPage: number
    page: number
  }
  error?: string
}

/**
 * API response type for primitive
 * @type APIPrimitiveResponse
 * @property {K} key - API response key
 * @property {T} value - API response value
 * @template K - API response key type
 * @template T - API response value type
 * @example APIPrimitiveResponse<"token", string>
 */
export type APIPrimitiveResponse<K extends string, T = unknown> = {
  [P in K]: T
}
