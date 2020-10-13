import { extend } from 'vee-validate';
import { required, email, max, min, confirmed } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "This field is required"
});

extend("max", {
  ...max,
  message: "This field must be {length} characters or less"
});

extend("min", {
  ...min,
  message: "This field must be {length} characters or more"
});

extend("email", {
  ...email,
  message: "This field must be a valid email"
});


extend("confirmed", {
  ...confirmed,
  message: 'The value for {_field_} field does not match'
});


extend("password", {
  params: ['target'],
  validate(value, { target }) {
    return value === target;
  },
  message: 'Password confirmation does not match'
});