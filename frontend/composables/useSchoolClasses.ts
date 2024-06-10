import type { SchoolClass } from "~/types/schoolclass"
import type { APIResponseArray } from "~/types/response"

export default function useSchoolClasses() {
  const schoolClasses = useState<SchoolClass[]>("schoolClasses", () => [])
  const config = useRuntimeConfig()

  async function fetchSchoolClasses() {
    if (schoolClasses.value.length) return

    try {
      const { data: classes } = useFetch<APIResponseArray<SchoolClass>>(
        "/schoolClasses",
        {
          baseURL: config.public.baseURL,
          pick: ["data"],
        },
      )

      // watch(classes, () => {
      //   schoolClasses.value = classes.value.data
      // })
    } catch (error) {
      schoolClasses.value = []
      return error
    }
  }

  return { schoolClasses, fetchSchoolClasses }
}
