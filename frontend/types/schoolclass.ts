import type { Year } from "~/types/year"
import type { Department } from "~/types/department"

/**
 * SchoolClass type
 * @type SchoolClass
 * @property {number} id - SchoolClass id
 * @property {string} name - SchoolClass name
 * @property {number} grade - SchoolClass grade
 * @property {number} students - SchoolClass students
 * @property {number} repetents - SchoolClass repetents
 * @property {number} budget - SchoolClass budget
 * @property {number} usedBudget - SchoolClass usedBudget
 * @property {Department} department - SchoolClass department
 * @property {Year} year - SchoolClass year
 */
export type SchoolClass = {
  id: number
  name: string
  grade: number
  students: number
  repetents?: number
  budget: number
  usedBudget: number
  department: Department
  year: Year
}

/**
 * SchoolClassDTO type
 * @type SchoolClassDTO
 * @see SchoolClass
 */
export type SchoolClassDTO = {
  name: string
  grade: number
  students: number
  repetents?: number
  budget: number
  usedBudget: number
  department: Department
  year: Year
}
