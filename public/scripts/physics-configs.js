const physicsConfig = {
    gravity: { x: 0, y: 1 },

    dynamicSelectors: [
        {
            selector: ".physics",
            options: {
                restitution: 0.4,
                friction: 0.1,
                collisionFilter: {
                    category: CATEGORY_MAP.PHYSICS,
                    mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
                }
            }
        },
        {
            selector: ".physics-fixed",
            options: {
                restitution: 0.4,
                friction: 0.1,
                collisionFilter: {
                    category: CATEGORY_MAP.PHYSICS,
                    mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.BALL | CATEGORY_MAP.CAT
                }
            }
        }
    ],

    staticSelectors: [
        {
            selector: ".collision",
            options: {
                isStatic: true,
                restitution: 0,
                friction: 1,
                collisionFilter: {
                    category: CATEGORY_NONE,
                    mask: CATEGORY_MAP.PHYSICS | CATEGORY_MAP.CAT
                }
            }
        }
    ],

    objectFactories: {
        sphere: createSphereFactory,
        hoop: createHoopFactory
    },
    spawnOnPage: {
        pageName: "about",
        ballCount: 100,
        hoop: true,
    }
};
