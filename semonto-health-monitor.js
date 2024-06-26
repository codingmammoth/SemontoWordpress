class SemontoHealthMonitor {
  // check if the warning threshold is higher than the Error threshold and return a error
  static checkThresholds (warningField, errorField) {
    const warning = parseInt(warningField.value) || 0
    const error = parseInt(errorField.value) || 0

    const inputFieldsDiv = warningField.closest('.input-fields')
    const errorMessageDiv = inputFieldsDiv.querySelector('.error-message')

    if (warning >= error) {
      if (!errorMessageDiv) {
        const errorMessage = document.createElement('div')
        errorMessage.className = 'error-message'
        errorMessage.textContent = 'Warning threshold should be less than the error threshold.'
        errorMessage.style.fontSize = '12px'
        inputFieldsDiv.appendChild(errorMessage)
      }

      [warningField, errorField].forEach(field => {
        field.classList.add('error-input')
        field.style.border = '2px solid red'
      })
    } else {
      if (errorMessageDiv) {
        errorMessageDiv.remove();
        [warningField, errorField].forEach(field => {
          field.classList.remove('error-input')
          field.style.border = '1px solid grey'
        })
      }
    }
  }

  // input fields become read only when checkbox is not checked
  static toggleInputFields (checkbox, warningField, errorField) {
    const isCheckboxChecked = checkbox.checked;
    [warningField, errorField].forEach(field => {
      field.readOnly = !isCheckboxChecked
    })
  }

  // input fields become read only when checkbox is not checked (for the disk space tests that have another naming method)
  static handleCheckboxChange (event) {
    const target = event.target
    if (target.name && target.name.startsWith('semonto_enable_')) {
      const test = target.name.replace('semonto_enable_', '').replace('_test', '')
      const warningField = document.querySelector('input[name="semonto_warning_threshold_' + test + '"]')
      const errorField = document.querySelector('input[name="semonto_error_threshold_' + test + '"]')
      SemontoHealthMonitor.toggleInputFields(target, warningField, errorField)
      SemontoHealthMonitor.checkThresholds(warningField, errorField)
    }
  }

  static handleInput (event) {
    const target = event.target
    if (target.name && target.name.startsWith('semonto_warning_threshold_')) {
      const test = target.name.replace('semonto_warning_threshold_', '').replace('_test', '')
      const errorField = document.querySelector('input[name="semonto_error_threshold_' + test + '"]')
      SemontoHealthMonitor.checkThresholds(target, errorField)
    } else if (target.name && target.name.startsWith('semonto_error_threshold_')) {
      const test = target.name.replace('semonto_error_threshold_', '').replace('_test', '')
      const warningField = document.querySelector('input[name="semonto_warning_threshold_' + test + '"]')
      SemontoHealthMonitor.checkThresholds(warningField, target)
    }
  }

  // tests read only on page reload or refresh
  static initializeTests () {
    const tests = ['now', '5m', '15m', 'wpdb', 'memory_usage']

    tests.forEach(function (test) {
      const enableCheckbox = document.querySelector('input[name="semonto_enable_' + test + '_test"]')
      const warningField = document.querySelector('input[name="semonto_warning_threshold_' + test + '"]')
      const errorField = document.querySelector('input[name="semonto_error_threshold_' + test + '"]')

      SemontoHealthMonitor.toggleInputFields(enableCheckbox, warningField, errorField)
      SemontoHealthMonitor.checkThresholds(warningField, errorField)
    })
  }

  constructor () {
    document.addEventListener('change', SemontoHealthMonitor.handleCheckboxChange)
    document.addEventListener('input', SemontoHealthMonitor.handleInput)

    SemontoHealthMonitor.initializeTests()
    // SemontoHealthMonitor.initializeDiskSpaceTests()
  }
}
