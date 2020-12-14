import multilineReadOnly from './multiline-readonly.component';
import multilineTextarea from './multiline-textarea.component';
import atkDatePicker from '../share/atk-date-picker';

export default {
    name: 'atk-multiline-cell',
    template: ` 
    <component :is="getComponent()"
        :fluid="true"  
        class="fluid" 
        @blur="onBlur"
        @input="onInput"
        @onChange="onChange"
        v-model="inputValue"
        :name="fieldName"
        ref="cell"
        v-bind="mapComponentProps()"></component>
  `,
    components: {
        'atk-multiline-readonly': multilineReadOnly,
        'atk-multiline-textarea': multilineTextarea,
        'atk-date-picker': atkDatePicker,
    },
    props: ['cellData', 'fieldValue'],
    data: function () {
        return {
            field: this.cellData.field,
            type: this.cellData.type,
            fieldName: '-' + this.cellData.field,
            inputValue: this.fieldValue,
            dirtyValue: this.fieldValue,
        };
    },
    computed: {
        isDirty: function () {
            return this.dirtyValue !== this.inputValue;
        },
    },
    methods: {
        getComponent: function () {
          return this.cellData.definition.component;
        },
        getComponentProps: function () {
          return this.cellData.definition.componentProps;
        },
      /**
       * Map component props accordingly.
       * Some component requires specific Props to be passed in.
       * This function make sure proper Props are set.
       */
        mapComponentProps: function() {
          if (this.getComponent() === 'atk-date-picker') {
            return {
              config: this.getComponentProps(),
              value: this.fieldValue,
            }
          }
          if (this.getComponent() === 'atk-multiline-readonly') {
            return {readOnlyValue: this.fieldValue}
          }

          return this.getComponentProps();
        },
        onInput: function (value) {
            this.inputValue = this.getTypeValue(value);
            this.$emit('update-value', this.field, this.inputValue);
        },
        onChange: function (value) {
            this.onInput(value);
        },
        /**
     * Tell parent row that input value has changed.
     *
     * @param e
     */
        onBlur: function (e) {
            if (this.isDirty) {
                this.$emit('post-value', this.field);
                this.dirtyValue = this.inputValue;
            }
        },
        /**
     * return input value based on their type.
     *
     * @param value
     * @returns {*}
     */
        getTypeValue: function (value) {
            let r = value;
            if (this.type === 'boolean') {
                r = value.target.checked;
            }
            return r;
        },
    },
};
