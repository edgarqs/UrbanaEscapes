import globals from "globals";
import pluginJs from "@eslint/js";


/** @type {import('eslint').Linter.Config[]} */
export default [
  {
    files: ["*.js"],
    languageOptions: {
       globals: globals.browser 
      },
    rules: {
            "prefer-const": "warn",
            "no-constant-binary-expression": "error",
            "quotes": ["error", "single"]
        },
    "env": {
            "browser": true,
            "commonjs": true,
            "es2021": true
        },
    "parserOptions": {
            "ecmaVersion": "latest"
        },
  },
  pluginJs.configs.recommended,
];