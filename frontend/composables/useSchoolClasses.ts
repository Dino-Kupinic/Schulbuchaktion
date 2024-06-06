import type { SchoolClass } from "~/types/schoolclass"
import type { APIResponseArray } from "~/types/response"

export default function useSchoolClasses() {
  const schoolClasses = useState<SchoolClass[]>("schoolClasses", () => [])

  async function fetchSchoolClasses() {
    if (schoolClasses.value.length) return

    const config = useRuntimeConfig()

    try {
      const { data, pending } = await useLazyFetch<
        APIResponseArray<SchoolClass>
      >("/schoolClasses", {
        baseURL: config.public.baseURL,
        pick: ["data"],
      })

      if (!pending) {
        schoolClasses.value = data.value.data
      }
    } catch (error) {
      schoolClasses.value = []
      return error
    }
  }

  return { schoolClasses, fetchSchoolClasses }
}
