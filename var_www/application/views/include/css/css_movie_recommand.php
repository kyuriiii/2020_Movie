<style>
    @media (max-width: 768px) {
        #recipeCarousel .carousel-inner .carousel-item > div {
            display: none;
        }
        #recipeCarousel .carousel-inner .carousel-item > div:first-child {
            display: block;
        }
    }

    #recipeCarousel .carousel-inner .carousel-item.active,
    #recipeCarousel .carousel-inner .carousel-item-next,
    #recipeCarousel .carousel-inner .carousel-item-prev {
        display: flex;
    }

    /* medium - display 4  */
    @media (min-width: 768px) {
        #recipeCarousel .carousel-inner .carousel-item-right.active,
        #recipeCarousel .carousel-inner .carousel-item-next {
            transform: translateX(50%);
        }

        #recipeCarousel .carousel-inner .carousel-item-left.active,
        #recipeCarousel .carousel-inner .carousel-item-prev {
            transform: translateX(-50%);
        }
    }

    /* large - display 6 */
    @media (min-width: 992px) {
        #recipeCarousel .carousel-inner .carousel-item-right.active,
        #recipeCarousel .carousel-inner .carousel-item-next {
            transform: translateX(50%);
        }

        #recipeCarousel .carousel-inner .carousel-item-left.active,
        #recipeCarousel .carousel-inner .carousel-item-prev {
            transform: translateX(-50%);
        }
    }

    #recipeCarousel .carousel-inner .carousel-item-right,
    #recipeCarousel .carousel-inner .carousel-item-left{
        transform: translateX(0);
    }

    .img-fluid,
    .img-genre-fluid{
        height: 300px;
    }
</style>