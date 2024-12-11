import globals from "globals";
import pluginJs from "@eslint/js";


/** @type {import('eslint').Linter.Config[]} */
export default [
  {
    languageOptions: {
       globals: globals.browser 
      },
    rules: {
            "no-unused-vars": "error",
            "no-undef": "error",
            "prefer-const": ["error", { "ignoreReadBeforeAssign": true }]
        }
  },
  pluginJs.configs.recommended,
];