import type { SchoolClass } from "~/types/schoolclass"

export default function useSchoolClasses() {
  const classes = useState<SchoolClass[]>("classes", () => [])

  async function fetchClasses() {
    if (classes.value.length) return

    const config = useRuntimeConfig()

    try {
      const { data } = useFetch<SchoolClass[]>("/schoolClasses", {
        baseURL: config.public.baseURL,
      })
    } catch (error) {
      classes.value = []
      return error
    }
  }

  return { classes }
}
