import type { Year } from "~/types/year"
import type { Book } from "~/types/book"
import type { SchoolClass } from "~/types/schoolclass"

export type BookOrder = {
  id: number
  count: number
  teacherCopy: boolean
  schoolClass: SchoolClass
  book: Book
  year: Year
  lastUser: string
  creationUser: string
}

export type BookOrderDTO = {
  count: number
  teacherCopy: boolean
  schoolClass: number
  book: number
  year: number
  lastUser: string
  creationUser: string
  repetents: string
}
