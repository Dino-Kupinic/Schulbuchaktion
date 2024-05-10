import type { Year } from "~/types/year"
import type { Subject } from "~/types/subject"
import type { Publisher } from "~/types/publisher"

/**
 * Type for Book
 * @type Book
 */
export type Book = {
  id: number
  orderNumber: number
  title: string
  shortTitle?: string
  schoolForm: number
  grade: string
  description: string
  bookPrice: number
  ebook: boolean
  ebookPlus: boolean
  subject: Subject
  publisher: Publisher
  year: Year
}
