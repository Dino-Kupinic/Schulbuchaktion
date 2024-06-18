/**
 * Department type
 * @type Department
 * @property {number} id - Department id
 * @property {string} name - Department name
 * @property {number} budget - Department budget
 * @property {number} usedBudget - Department usedBudget
 * @property {Date} validFrom - Department validFrom
 * @property {Date} validTo - Department validTo
 */
export type Department = {
  id: number
  name: string
  budget: number
  usedBudget: number
  validFrom?: Date
  validTo?: Date
}

/**
 * DepartmentDTO type
 * @type DepartmentDTO
 * @see Department
 */
export type DepartmentDTO = {
  name: string
  budget: number
  usedBudget: number
  validFrom?: Date
  validTo?: Date
}
