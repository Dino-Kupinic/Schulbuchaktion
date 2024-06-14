import type { Year } from "~/types/year"
import type { APIResponseObject } from "~/types/response"

export default function useCurrentYear() {
  const currentYear = useState<Year | null>("currentYear", () => null)
  const config = useRuntimeConfig()

  async function fetchCurrentYear() {
    if (currentYear.value !== null) return

    try {
      const { data: year, error } = await useAsyncData("year", () =>
        $fetch<APIResponseObject<Year>>(
          `/years/year/${new Date().getFullYear()}`,
          {
            baseURL: config.public.baseURL,
          },
        ),
      )

      if (error.value) {
        throw new Error(error.value.message)
      }

      currentYear.value = year.value?.data ?? null
    } catch (error) {
      console.error("Failed to fetch current year:", error)
      currentYear.value = null
      return error
    }
  }

  return { currentYear, fetchCurrentYear }
}
