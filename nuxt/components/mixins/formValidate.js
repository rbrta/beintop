export const FormValidation = {
  data() {
    return {
      errors: {},
    }
  },

  methods: {
    hasError(field) {
      if (typeof this.errors !== 'undefined')
        return this.errors.hasOwnProperty(field);
    },
    getError(key) {
      if (typeof this.errors !== 'undefined')
        return this.errors.hasOwnProperty(key) ? this.errors[key][0] : '';
    },
    getErrors(key) {
      if (typeof this.errors !== 'undefined')
        return this.errors.hasOwnProperty(key) ? this.errors[key] : [];
    },
  }
}
