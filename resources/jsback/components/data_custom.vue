<template>
  <div
    class="FormDate"
    @keyup.capture="updateValue"
  >
    <input
      v-if="showDay"
      ref="day"
      v-model="day"
      class="FormDate__input FormDate__input--day"
      type="number"
      placeholder="dd"
      @input="updateDay"
      @blur="day = day.padStart(2, 0)">
    <span
      v-if="showDay && showMonth"
      class="FormDate__divider"
    >/</span>
    <input
      v-if="showMonth"
      ref="month"
      v-model="month"
      class="FormDate__input FormDate__input--month"
      type="number"
      placeholder="mm"
      @input="updateMonth"
      @blur="month = month.padStart(2, 0)">
    <span
      v-if="showYear && (showDay || showMonth)"
      class="FormDate__divider"
    >/</span>
    <input
      v-if="showYear"
      ref="year"
      v-model="year"
      class="FormDate__input FormDate__input--year"
      type="number"
      placeholder="yyyy"
      @blur="year = year.padStart(4, 0)">
  </div>
</template>

<script>
export default {
  name: 'FormDate',
  props: {
    value: {
      type: [Number, String],
      required: true,
    },
    // ...
  },
  data() {
    return {
      showDay:true,
      showMonth:true,
      showYear:true,
      
      month: `${this.value ? new Date(this.value).getDate() : ''}`,
      day: `${this.value ? new Date(this.value).getMonth() + 1 : ''}`,
      year: `${this.value ? new Date(this.value).getFullYear(): ''}`,
    };
  },
  watch: {
    year(current, prev) {
      if (current > 9999) this.year = prev;
    },

    month(current, prev) {
      if (current > 12) this.month = 12;
    },

    day(current, prev) {
      if (current > 31) this.day = 31;
    },
  },
    
  methods: {
    updateValue() {
      const timestamp = Date.parse(`${this.year.padStart(4, 0)}-${this.month}-${this.day}`);

      if (Number.isNaN(timestamp)) return;

      let dia = "0" + this.day ;
      let mes = "0" + this.month ;
      let ano = this.year.padStart(4, 0);
      let data = dia.substr(-2) + "/" + mes.substr(-2) + "/" + ano;

      this.$emit('input', data);
    },
    updateDay() {
      if (!this.day.length || parseInt(this.day, 10) < 4) return;
      if (this.showMonth) this.$refs.month.select();
      else if (this.showYear) this.$refs.year.select();
    },
    updateMonth() {
      if (!this.month.length || parseInt(this.month, 10) < 2) return;
      if (this.showYear) this.$refs.year.select();
    },
    // ...
  },
};
</script>

<style lang="scss">

input.FormDate__input.FormDate__input{
    width: 3em;
    border: 0;
    margin:0;
    height: 58px;
    line-height: 58px;
    &--year {
      width: 4em;
}

}
.FormDate {
   $spacing: 0.75em;
  display: inline-flex;
  position: relative;
  overflow: hidden;
  border: 1px solid #dfdcdc;
  border-radius: 05px;

  
  // 1. Hide the spinner button in Chrome, Safari and Firefox.
  &__input {
    margin:0;
    width: 3em;
    padding: $spacing;
    padding-right: $spacing / 2;
    padding-left: $spacing / 2;
    border: none;
    text-align: center;
    -moz-appearance: textfield; // 1

    &::-webkit-inner-spin-button {
      display: none; // 1
    }

    &:first-child {
      padding-left: $spacing;
    }

    &:last-child {
      padding-right: $spacing;
    }

    &:focus {
      outline: none;
    }

    &--day,
    &--month {
      width: 3em;
    }

    &--year {
      width: 4em;
    }
  }

  &__divider {
    pointer-events: none;
    line-height: 58px;
  }
  // ...  
}
</style>