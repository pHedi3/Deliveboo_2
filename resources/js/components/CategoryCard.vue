<template>
    <div class="mycard">
        <img :src="img" alt="">
        <h4>{{name}}</h4>
    </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      restaurant: []

    };
  },
  props: {
      name: String,
      img: String,
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";

    .mycard {
        background-color: rgba($color: #ffffff, $alpha: .8);
        border-radius: 12px;
        img {
            width: 100%;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    h4 {
        margin-top: 8px;
        font-weight: 900;
    }
    h5, h6 {
        font-weight: 400;
    }
    h6 {
        color: #555;
        font-size: 12px;
    }
    }

</style>
