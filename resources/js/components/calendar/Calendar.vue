<template>
  <div class="calendar-wrapper">
    <div class="date-display">
      {{ formatSelectedDate || '' }}
    </div>
    <div class="calendar-header">
      <button @click="previousMonth" :disabled="!canNavigateToPreviousMonth">
        &lt;
      </button>
      <div class="month-selector">
        {{ currentMonthName }}
      </div>
      <div class="year-selector">
        {{ currentYear }}
      </div>
      <button @click="nextMonth" :disabled="!canNavigateToNextMonth">
        &gt;
      </button>
    </div>

    <div class="calendar-days-header">
      <div v-for="day in weekDays" :key="day" class="day-name" 
           :class="{ 'weekend': day === 'Dom' }">
        {{ day }}
      </div>
    </div>

    <div class="calendar-grid">
      <div
        v-for="day in calendarDays"
        :key="day.date.toISOString()"
        class="calendar-day"
        :class="{
          'disabled': !day.isCurrentMonth,
          'today': day.isToday,
          'selected': isSelected(day.date),
          'weekend': new Date(day.date).getDay() === 0
        }"
        @click="selectDate(day)"
      >
        {{ day.dayNumber }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Calendar',
  
  props: {
    value: {
      type: Date,
      default: () => new Date()
    }
  },

  data() {
    return {
      currentDate: new Date(),
      selectedDate: this.value,
      weekDays: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
      months: [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
      ],
      displayDate: new Date()
    }
  },

  computed: {
    currentYear() {
      return this.displayDate.getFullYear()
    },

    currentMonth() {
      return this.displayDate.getMonth()
    },

    currentMonthName() {
      return this.months[this.displayDate.getMonth()]
    },

    canNavigateToPreviousMonth() {
      const minDate = new Date()
      minDate.setFullYear(minDate.getFullYear() - 1)
      const firstOfDisplayMonth = new Date(this.displayDate.getFullYear(), this.displayDate.getMonth(), 1)
      return firstOfDisplayMonth > minDate
    },

    canNavigateToNextMonth() {
      const maxDate = new Date()
      maxDate.setFullYear(maxDate.getFullYear() + 1)
      const lastOfDisplayMonth = new Date(this.displayDate.getFullYear(), this.displayDate.getMonth() + 1, 0)
      return lastOfDisplayMonth < maxDate
    },

    calendarDays() {
      const year = this.displayDate.getFullYear()
      const month = this.displayDate.getMonth()
      
      const firstDayOfMonth = new Date(year, month, 1)
      const lastDayOfMonth = new Date(year, month + 1, 0)
      
      const days = []
      
      // Días del mes anterior
      for (let i = firstDayOfMonth.getDay(); i > 0; i--) {
        const date = new Date(year, month, -i + 1)
        days.push({
          date: date,
          dayNumber: date.getDate(),
          isCurrentMonth: false,
          isToday: this.isToday(date)
        })
      }
      
      // Días del mes actual
      for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
        const date = new Date(year, month, i)
        days.push({
          date: date,
          dayNumber: i,
          isCurrentMonth: true,
          isToday: this.isToday(date)
        })
      }
      
      // Días del mes siguiente
      const remainingDays = 42 - days.length
      for (let i = 1; i <= remainingDays; i++) {
        const date = new Date(year, month + 1, i)
        days.push({
          date: date,
          dayNumber: date.getDate(),
          isCurrentMonth: false,
          isToday: this.isToday(date)
        })
      }
      
      return days
    },

    formatSelectedDate() {
      if (!this.selectedDate) return ''
      return this.selectedDate.toISOString().split('T')[0]
    }
  },

  watch: {
    value: {
      handler(newVal) {
        if (newVal) {
          this.currentDate = new Date(newVal);
          this.selectedDate = new Date(newVal);
          this.displayDate = new Date(newVal);
          this.generateCalendarDays();
        }
      },
      immediate: true
    }
  },

  methods: {
    isToday(date) {
      const today = new Date()
      return date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
    },

    isSelected(date) {
      if (!this.selectedDate) return false
      return date.getDate() === this.selectedDate.getDate() &&
        date.getMonth() === this.selectedDate.getMonth() &&
        date.getFullYear() === this.selectedDate.getFullYear()
    },

    selectDate(day) {
      if (!day.isCurrentMonth) return
      this.selectedDate = day.date
      this.$emit('input', day.date)
    },

    previousMonth() {
      this.displayDate = new Date(this.displayDate.getFullYear(), this.displayDate.getMonth() - 1)
    },

    nextMonth() {
      this.displayDate = new Date(this.displayDate.getFullYear(), this.displayDate.getMonth() + 1)
    },

    generateCalendarDays() {
      // Implementation of generateCalendarDays method
    }
  }
}
</script>

<style scoped>
.calendar-wrapper {
  width: 100%;
  min-width: 250px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-family: Arial, sans-serif;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  background: white;
  overflow: hidden;
}

.date-display {
  padding: 10px;
  text-align: center;
  font-size: 1.1em;
  border-bottom: 1px solid #eee;
  height: 20px;
  line-height: 20px;
  color: #333;
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px;
  background-color: white;
  border-bottom: 1px solid #eee;
}

.calendar-header button {
  border: none;
  background: none;
  cursor: pointer;
  padding: 5px 10px;
  color: #666;
  font-size: 0.9em;
}

.month-selector, .year-selector {
  font-size: 0.9em;
  color: #333;
  cursor: pointer;
}

.calendar-days-header {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  padding: 5px 0;
  background-color: white;
  border-bottom: 1px solid #eee;
}

.day-name {
  font-size: 0.8em;
  color: #666;
}

.weekend {
  color: #2196F3;
}

.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background-color: white;
  padding: 5px;
}

.calendar-day {
  padding: 8px 0;
  text-align: center;
  font-size: 0.9em;
  cursor: pointer;
  border-radius: 4px;
  margin: 1px;
}

.calendar-day:hover:not(.disabled) {
  background-color: #f5f5f5;
}

.disabled {
  color: #ddd;
  cursor: not-allowed;
}

.today {
  font-weight: bold;
  color: #333;
}

.selected {
  background-color: #2196F3;
  color: white;
  font-weight: normal;
}

.calendar-header button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style> 