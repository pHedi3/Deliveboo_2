<template>
    <div class="mycard">
        <div class="box"> 
             <img :src="img" alt="category-img">
           
        </div>
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
        box-shadow: 0 0 3px;
        .box{
            width: 100%;
             overflow: hidden;
             position: relative;
             border-radius: 12px;
        
            img{
                height: 110%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(- 50%, -50%);
                display: none;  

            }
        }
         @media(min-width:576px) {
             .box {
                 height: 150px;
                img {
                    display: block;
                 }
             }
         
      }
        img {
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
