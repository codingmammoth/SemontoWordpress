class SemontoHealthMonitor {
  tests = ['now', '5m', '15m', 'wpdb', 'memory_usage']
  diskSpaceTests = ['disk_space', 'disk_space_inode']
  errors = false

  // check if the warning threshold is higher than the Error threshold and return a error
  checkThresholds (warningField, errorField) {
    const warning = parseInt(warningField.value) || 0
    const error = parseInt(errorField.value) || 0

    const inputFieldsDiv = warningField.closest('.semonto-health-monitor__test').parentElement
    const errorMessageDiv = inputFieldsDiv.querySelector('.semonto-health-monitor__error-message')

    if (warning >= error) {
      this.errors = true

      if (!errorMessageDiv) {
        const errorMessage = document.createElement('div')
        errorMessage.className = 'semonto-health-monitor__error-message'
        errorMessage.textContent = 'Warning threshold should be less than the error threshold.'
        inputFieldsDiv.appendChild(errorMessage)
      }

      [warningField, errorField].forEach(field => {
        field.classList.add('is-invalid')
      })
    } else {
      if (errorMessageDiv) {
        errorMessageDiv.remove();
        [warningField, errorField].forEach(field => {
          field.classList.remove('is-invalid')
        })
      }
    }
  }

  // input fields become read only when checkbox is not checked
  toggleInputFields (checkbox, warningField, errorField) {
    const isCheckboxChecked = checkbox.checked;
    [warningField, errorField].forEach(field => {
      field.readOnly = !isCheckboxChecked
    })
  }

  // input fields become read only when checkbox is not checked (for the disk space tests that have another naming method)
  handleCheckboxChange (event) {
    if (event.target.type !== 'checkbox') { return }

    const target = event.target
    const targetName = event.target.name

    if (targetName) {
      let test = ''

      if (targetName.startsWith('semonto_config_disk_space_inode')) {
        test = 'disk_space_inode'
      } else if (targetName.startsWith('semonto_config_disk_space')) {
        test = 'disk_space'
      } else if (targetName.startsWith('semonto_enable_')) {
        test = targetName.replace('semonto_enable_', '').replace('_test', '')
      }

      if (test && targetName.startsWith('semonto_enable_') && this.tests.includes(test)) {
        // Non-diskspace tests
        const warningField = this.formElement.querySelector('input[name="semonto_warning_threshold_' + test + '"]')
        const errorField = this.formElement.querySelector('input[name="semonto_error_threshold_' + test + '"]')

        this.toggleInputFields(target, warningField, errorField)
        this.checkThresholds(warningField, errorField)
      } else if (test && targetName.startsWith('semonto_config_disk_space') || targetName.startsWith('semonto_config_disk_space_inode')) {
        // Disk space tests
        const warningSelector = 'input[name="' + targetName.replace('[enabled]', '[warning_percentage_threshold]' + '"]')
        const errorSelector = 'input[name="' + targetName.replace('[enabled]', '[error_percentage_threshold]' + '"]')

        const warningField = this.formElement.querySelector(warningSelector)
        const errorField = this.formElement.querySelector(errorSelector)

        this.toggleInputFields(target, warningField, errorField)
        this.checkThresholds(warningField, errorField)
      }
    }
  }

  handleInput (event) {
    if (event.target.type !== 'number') { return }

    const targetName = event.target.name

    if (targetName) {
      let test = ''

      if (targetName.startsWith('semonto_config_disk_space_inode')) {
        test = 'disk_space_inode'
      } else if (targetName.startsWith('semonto_config_disk_space')) {
        test = 'disk_space'
      } else if (targetName.startsWith('semonto_warning_threshold_')) {
        test = targetName.replace('semonto_warning_threshold_', '').replace('_test', '')
      } else if (targetName.startsWith('semonto_error_threshold_')) {
        test = targetName.replace('semonto_error_threshold_', '').replace('_test', '')
      }

      if (test && (targetName.startsWith('semonto_warning_threshold_') || targetName.startsWith('semonto_error_threshold_')) && this.tests.includes(test)) {
        const warningField = this.formElement.querySelector('input[name="semonto_warning_threshold_' + test + '"]')
        const errorField = this.formElement.querySelector('input[name="semonto_error_threshold_' + test + '"]')

        this.checkThresholds(warningField, errorField)
      } else if (test && targetName.startsWith('semonto_config_disk_space') || targetName.startsWith('semonto_config_disk_space_inode')) {
        const baseName = targetName.replace('[warning_percentage_threshold]', '').replace('[error_percentage_threshold]', '')
        const warningSelector = 'input[name="' + baseName + '[warning_percentage_threshold]' + '"]'
        const errorSelector = 'input[name="' + baseName + '[error_percentage_threshold]' + '"]'
        const warningField = this.formElement.querySelector(warningSelector)
        const errorField = this.formElement.querySelector(errorSelector)

        this.checkThresholds(warningField, errorField)
      }
    }
  }

  validateDiskTests () {
    this.tests.forEach((test) => {
      const enableCheckbox = this.formElement.querySelector('input[name="semonto_enable_' + test + '_test"]')
      const warningField = this.formElement.querySelector('input[name="semonto_warning_threshold_' + test + '"]')
      const errorField = this.formElement.querySelector('input[name="semonto_error_threshold_' + test + '"]')

      this.toggleInputFields(enableCheckbox, warningField, errorField)
      this.checkThresholds(warningField, errorField)
    })
  }

  validateDiskSpaceTests() {
    this.diskSpaceTests.forEach((test) => {
      const checkBoxes = Array.from(this.formElement.querySelectorAll('input[type="checkbox"][name^="semonto_config_' + test + '["]'))

      checkBoxes.forEach((checkBox) => {
        const checkBoxName = checkBox.name
        const warningSelector = 'input[name="' + checkBoxName.replace('[enabled]', '[warning_percentage_threshold]' + '"]')
        const errorSelector = 'input[name="' + checkBoxName.replace('[enabled]', '[error_percentage_threshold]' + '"]')

        const warningField = this.formElement.querySelector(warningSelector)
        const errorField = this.formElement.querySelector(errorSelector)

        this.toggleInputFields(checkBox, warningField, errorField)
        this.checkThresholds(warningField, errorField)
      })
    })
  }

  handleSubmit (event) {
    event.preventDefault()

    this.errors = false

    this.validateDiskTests()
    this.validateDiskSpaceTests()

    if (!this.errors) {
      this.formElement.submit()
    }
  }

  constructor () {
    this.formElement = document.querySelector('.semonto-health-monitor__form')

    if (this.formElement) {
      this.formElement.addEventListener('change', (event) => this.handleCheckboxChange(event))
      this.formElement.addEventListener('input', (event) => this.handleInput(event))

      this.validateDiskTests()
      this.validateDiskSpaceTests()

      this.formElement.addEventListener('submit', (event) => {
        this.handleSubmit(event)
      })
    }
  }
}
