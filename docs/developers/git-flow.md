# Git Flow

Here we discuss the branches and their meaning.

## Branches

### Main Branches:

**Main**: 
Represents the production-ready code. Only stable, fully tested code should be merged into this branch.

**Develop**: 
Acts as the integration branch for features. All feature branches are eventually merged into this branch.

### Support Branches:

**Feature branches**: 
Used for developing new features or enhancements. These branches are created off the develop branch
and are merged back into it upon completion.

**Hotfix branches**: 
Used to quickly address critical bugs or issues in the production code. They are created from the
main branch, fixed, and then merged back into both master and develop.