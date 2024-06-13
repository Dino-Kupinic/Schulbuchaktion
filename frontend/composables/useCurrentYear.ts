// import type { APIResponseObject } from "~/types/response"
// import type { Year } from "~/types/year"

import type { Year } from "~/types/year"
import type { APIResponseObject } from "~/types/response"
import type { Y } from "vitest/dist/reporters-yx5ZTtEV.js"

export default function useCurrentYear() {
  const currentYear = useState<number | null>("currentYear", () => null)
  const config = useRuntimeConfig()

  function fetchCurrentYear() {
    if (currentYear.value) return

    try {
      const { data: year } = useFetch<APIResponseObject<Year>>(
        `/year/${new Date().getFullYear()}`,
        {
          onResponse({ response }) {
            year.value = response._data.data
            console.log(year.value)
            console.log(response)
          },
          onRequestError({ error }) {
            throw createError({
              statusMessage: error.message,
            })
          },
          baseURL: config.public.baseURL,
        },
      )
    } catch (error) {
      currentYear.value = null
      return error
    }
  }

  return { currentYear, fetchCurrentYear }
}
