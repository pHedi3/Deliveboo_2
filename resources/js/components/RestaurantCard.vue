<template>
    <div class="bord col-lg-3 col-md-4 col-6">
        <a :href="'/restaurant/' + id">
        <div class="mycard">
            <img src="/img/restaurant.jpg" alt="">
            <h4>{{name}}</h4>
            <h5 v-for="element in category" :key="element.id">{{element.name}}</h5>
            <h6>{{address}}</h6>
        </div>
        </a>
    </div>
</template>

<script>
export default {
  data() {
    return {
    };
  },
  props: {
      id: Number,
      name: String,
      address: String,
      img: String,
      category: String
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
    a {
        color: black;
    }
    .mycard {
        background-color: rgba($color: #ffffff, $alpha: .8);
        border-radius: 12px;
        padding: 8px;
        height: 100%;
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
    .bord {
        margin-bottom: 30px;
    }
    h5 {
        margin-right: 4px;
        display: inline-block;
    }

</style>
