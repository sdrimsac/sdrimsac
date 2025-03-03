<template>
  <div class="clock-container">
    <svg :width="size" :height="size" :viewBox="viewBox">
      <circle :cx="center" :cy="center" :r="radius" class="clock-face"/>

      <line
        v-for="n in 12"
        :key="n"
        :x1="getTickX(n, true)" :y1="getTickY(n, true)"
        :x2="getTickX(n, false)" :y2="getTickY(n, false)"
        class="hour-tick"
      />

      <line
        :x1="center" :y1="center"
        :x2="hourX" :y2="hourY"
        class="hour-hand"
        @mousedown="startDrag('hour', $event)"
      />

      <line
        :x1="center" :y1="center"
        :x2="minuteX" :y2="minuteY"
        class="minute-hand"
        @mousedown="startDrag('minute', $event)"
      />

      <circle :cx="center" :cy="center" r="5" class="center-dot"/>
    </svg>
    <p>Hora seleccionada: {{ formattedTime }}</p>
  </div>
</template>

<script>
export default {
  name: "Clock",
  data() {
    return {
      size: 200,
      center: 100,
      radius: 90,
      selectedHour: 12,
      selectedMinute: 0,
      dragging: null,
    };
  },
  computed: {
    formattedTime() {
      const hour = this.selectedHour.toString().padStart(2, '0');
      const minute = this.selectedMinute.toString().padStart(2, '0');
      return `${hour}:${minute}`;
    },
    viewBox() {
      return `0 0 ${this.size} ${this.size}`;
    },
    hourAngle() {
      return (this.selectedHour % 12) * 30;
    },
    minuteAngle() {
      return this.selectedMinute * 6;
    },
    hourX() {
      return this.center + Math.cos(this.toRadians(this.hourAngle - 90)) * (this.radius * 0.5);
    },
    hourY() {
      return this.center + Math.sin(this.toRadians(this.hourAngle - 90)) * (this.radius * 0.5);
    },
    minuteX() {
      return this.center + Math.cos(this.toRadians(this.minuteAngle - 90)) * (this.radius * 0.8);
    },
    minuteY() {
      return this.center + Math.sin(this.toRadians(this.minuteAngle - 90)) * (this.radius * 0.8);
    }
  },
  created() {
    // Inicializar con la hora actual
    const now = new Date();
    this.selectedHour = now.getHours() % 12 || 12;
    this.selectedMinute = now.getMinutes();
  },
  methods: {
    toRadians(degrees) {
      return degrees * (Math.PI / 180);
    },
    getTickX(n, inner) {
      let angle = this.toRadians(n * 30 - 90);
      return this.center + Math.cos(angle) * (inner ? this.radius * 0.85 : this.radius);
    },
    getTickY(n, inner) {
      let angle = this.toRadians(n * 30 - 90);
      return this.center + Math.sin(angle) * (inner ? this.radius * 0.85 : this.radius);
    },
    startDrag(type, event) {
      this.dragging = type;
      document.addEventListener("mousemove", this.dragMove);
      document.addEventListener("mouseup", this.stopDrag);
    },
    dragMove(event) {
      if (!this.dragging) return;

      let rect = event.target.closest("svg").getBoundingClientRect();
      let x = event.clientX - rect.left - this.center;
      let y = event.clientY - rect.top - this.center;
      let angle = Math.atan2(y, x) * (180 / Math.PI) + 90;
      if (angle < 0) angle += 360;

      if (this.dragging === "hour") {
        this.selectedHour = Math.round(angle / 30) % 12 || 12;
      } else if (this.dragging === "minute") {
        this.selectedMinute = Math.round(angle / 6) % 60;
      }
    },
    stopDrag() {
      this.dragging = null;
      document.removeEventListener("mousemove", this.dragMove);
      document.removeEventListener("mouseup", this.stopDrag);
    }
  }
};
</script>

<style scoped>
.clock-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.clock-face {
  fill: white;
  stroke: black;
  stroke-width: 2;
}

.hour-tick {
  stroke: black;
  stroke-width: 2;
}

.hour-hand, .minute-hand {
  stroke: black;
  stroke-width: 4;
  stroke-linecap: round;
  cursor: pointer;
}

.center-dot {
  fill: black;
}
</style>
