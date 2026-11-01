import "./bootstrap";
import "./theme";
import "./contact";
import "./nav";

import Matter from "matter-js";
import { GRAVITY_CONFIG } from "./config/gravity.js";
import { SKILLS } from "./config/skills.js";
import { attachSkillTooltip } from "./skill-tooltip.js";
import { getSkillPositions, observeGravitySize } from "./gravity-layout.js";

const {
    Engine,
    Render,
    Bodies,
    Runner,
    Composite,
    Events,
    Mouse,
    MouseConstraint,
} = Matter;
const container = document.querySelector(".gravity-container");

console.log("Container :", container);
console.log("Hauteur :", container?.clientHeight);
console.log("Largeur :", container?.clientWidth);

function createBall(x, y, color, logo, name) {
    const ball = Bodies.circle(x, y, GRAVITY_CONFIG.BALL_RADIUS, {
        label: name,
        restitution: GRAVITY_CONFIG.BALL_RESTITUTION,
        render: {
            sprite: {
                texture: logo,
                xScale: 0,
                yScale: 0,
            },
        },
    });

    // Conserver la couleur de la bordure
    ball.borderColor = color;

    const image = new Image();

    image.onload = () => {
        const logoSize = GRAVITY_CONFIG.BALL_RADIUS * 1.3;

        const scale = Math.min(
            logoSize / image.naturalWidth,
            logoSize / image.naturalHeight,
        );

        ball.render.sprite.xScale = scale;
        ball.render.sprite.yScale = scale;
    };

    image.onerror = () => {
        console.error("Impossible de charger :", logo);
    };

    image.src = logo;

    return ball;
}

if (container) {
    const positions = getSkillPositions(container.clientWidth, SKILLS.length);
    const balls = SKILLS.map((skill, index) => createBall(
        positions[index].x,
        positions[index].y,
        GRAVITY_CONFIG.COLORS.PURPLE,
        skill.logo,
        skill.name,
    ));

    // 1. Créer le moteur physique
    const engine = Engine.create();

    // 2. Créer l'affichage
    const render = Render.create({
        element: container,
        engine: engine,
        options: {
            width: container.clientWidth,
            height: container.clientHeight,
            wireframes: false,

            background: "transparent",
        },
    });

    // 4. Créer un sol, a laquel il rebondit
    const ground = Bodies.rectangle(
        container.clientWidth / 2,
        container.clientHeight - 10,
        container.clientWidth,
        20,
        {
            isStatic: true, // permet de fixer le sol, sinon il tomberait aussi
            render: {
                strokeStyle: "transparent",
                fillStyle: "transparent",
            },
        },
    );
    // Créer les murs gauche et droit
    const wallLeft = Bodies.rectangle(
        -10,
        container.clientHeight / 2,
        20,
        container.clientHeight,
        {
            isStatic: true,
            render: {
                strokeStyle: "transparent",
                fillStyle: "transparent",
            },
        },
    );

    const wallRight = Bodies.rectangle(
        container.clientWidth + 10,
        container.clientHeight / 2,
        20,
        container.clientHeight,
        {
            isStatic: true,
            render: {
                strokeStyle: "transparent",
                fillStyle: "transparent",
            },
        },
    );
    const roof = Bodies.rectangle(
        container.clientWidth / 2,
        10,
        container.clientWidth,
        20,
        {
            isStatic: true, // permet de fixer le sol, sinon il tomberait aussi
            render: {
                strokeStyle: "transparent",
                fillStyle: "transparent",
            },
        },
    );

    // 5. Ajouter les objets au monde
    Composite.add(engine.world, [...balls, ground, wallLeft, wallRight, roof]); // ...balls est une syntaxe qui permet de décomposer le tableau balls en éléments individuels

    // 6. Lancer la simulation
    Render.run(render);

    Events.on(render, "afterRender", () => {
        const ctx = render.context;

        balls.forEach((ball) => {
            ctx.save();

            // Déplacer l'origine au centre du cercle
            ctx.translate(ball.position.x, ball.position.y);

            // Dessiner le contour circulaire
            ctx.beginPath();
            ctx.arc(0, 0, GRAVITY_CONFIG.BALL_RADIUS, 0, Math.PI * 2);

            ctx.strokeStyle = ball.borderColor;
            ctx.lineWidth = 3;
            ctx.stroke();

            ctx.restore();
        });
    });

    const mouse = Mouse.create(render.canvas);

    // Matter.js bloque la molette sur le canvas : on la rend à la page pour pouvoir défiler
    mouse.element.removeEventListener("wheel", mouse.mousewheel);
    mouse.element.removeEventListener("mousewheel", mouse.mousewheel);
    mouse.element.removeEventListener("DOMMouseScroll", mouse.mousewheel);

    const mouseConstraint = MouseConstraint.create(engine, {
        mouse: mouse,
        constraint: {
            stiffness: 0.2,
            render: {
                visible: false,
            },
        },
    });

    Composite.add(engine.world, mouseConstraint);

    render.mouse = mouse;
    attachSkillTooltip(render, container, balls);
    observeGravitySize(render, container, balls, { ground, roof, wallLeft, wallRight });

    const runner = Runner.create();
    Runner.run(runner, engine);
}
