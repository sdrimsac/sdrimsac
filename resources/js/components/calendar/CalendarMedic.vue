<template>
  <div class="calendar bg-white">
    <div class="calendar-header">
      <div class="selected-full-date">{{ selectedFullDate }}</div>
      <div class="month-navigation">
        <el-button @click="previousMonth" icon="el-icon-arrow-left"></el-button>
        <span>{{ currentMonthName }} {{ currentYear }}</span>
        <el-button @click="nextMonth" icon="el-icon-arrow-right"></el-button>
      </div>
    </div>
    <div class="calendar-body">
      <div class="calendar-weekdays">
        <div v-for="day in weekDays" :key="day">{{ day }}</div>
      </div>
      <div class="calendar-dates">
        <div 
          v-for="date in calendarDates" 
          :key="`${date.year}-${date.month}-${date.day}`"
          class="calendar-date"
          :class="{
            'other-month': date.otherMonth,
            'selected': isSelected(date),
            'today': isToday(date)
          }"
          @click="selectDate(date)"
        >
          {{ date.day }}
        </div>
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
      default: null
    }
  },

  data() {
    return {
      currentDate: new Date(),
      selectedDate: this.value || new Date(),
      weekDays: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
    }
  },

  computed: {
    currentYear() {
      return this.currentDate.getFullYear()
    },

    currentMonth() {
      return this.currentDate.getMonth()
    },

    currentMonthName() {
      return new Date(this.currentYear, this.currentMonth).toLocaleString('default', { month: 'long' })
    },

    calendarDates() {
      const dates = []
      const firstDay = new Date(this.currentYear, this.currentMonth, 1)
      const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0)
      const startDay = firstDay.getDay()

      // Días del mes anterior
      for (let i = startDay - 1; i >= 0; i--) {
        const date = new Date(this.currentYear, this.currentMonth, -i)
        dates.push({
          day: date.getDate(),
          month: date.getMonth(),
          year: date.getFullYear(),
          otherMonth: true
        })
      }

      // Días del mes actual
      for (let i = 1; i <= lastDay.getDate(); i++) {
        dates.push({
          day: i,
          month: this.currentMonth,
          year: this.currentYear,
          otherMonth: false
        })
      }

      // Días del mes siguiente
      const remainingDays = 42 - dates.length
      for (let i = 1; i <= remainingDays; i++) {
        dates.push({
          day: i,
          month: this.currentMonth + 1,
          year: this.currentYear,
          otherMonth: true
        })
      }

      return dates
    },

    selectedFullDate() {
      if (!this.selectedDate) return ''
      return this.selectedDate.toLocaleDateString('es-ES', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }
  },

  methods: {
    previousMonth() {
      this.currentDate = new Date(this.currentYear, this.currentMonth - 1)
    },

    nextMonth() {
      this.currentDate = new Date(this.currentYear, this.currentMonth + 1)
    },

    selectDate(date) {
      const selectedDate = new Date(date.year, date.month, date.day)
      this.selectedDate = selectedDate
      this.$emit('input', selectedDate)
    },

    isSelected(date) {
      if (!this.selectedDate) return false
      return date.day === this.selectedDate.getDate() &&
             date.month === this.selectedDate.getMonth() &&
             date.year === this.selectedDate.getFullYear()
    },

    isToday(date) {
      const today = new Date()
      return date.day === today.getDate() &&
             date.month === today.getMonth() &&
             date.year === today.getFullYear()
    }
  }
}
</script>

<style scoped>
.calendar {
  width: 100%;
  border: 1px solid #dcdfe6;
  border-radius: 4px;
  padding: 10px;
}

.calendar-header {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.selected-full-date {
  text-align: center;
  font-weight: bold;
  text-transform: capitalize;
}

.month-navigation {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  font-weight: bold;
  margin-bottom: 5px;
}

.calendar-dates {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 2px;
}

.calendar-date {
  padding: 8px;
  text-align: center;
  cursor: pointer;
  border-radius: 4px;
}

.calendar-date:hover {
  background-color: #f5f7fa;
}

.other-month {
  color: #c0c4cc;
}

.selected {
  background-color: #409eff;
  color: white;
}

.today {
  border: 1px solid #409eff;
}

.selected.today {
  border: none;
}
</style>