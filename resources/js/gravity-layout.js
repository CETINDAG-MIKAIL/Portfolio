import Matter from "matter-js";
import { GRAVITY_CONFIG } from "./config/gravity.js";

export function getSkillPositions(width, count, height = Infinity) {
    const radius = GRAVITY_CONFIG.BALL_RADIUS;
    let margin = radius + 8;
    const spacing = radius * 2 + 12;
    let columns = Math.max(1, Math.min(count, Math.floor((width - margin * 2) / spacing) + 1));
    const startY = Math.max(GRAVITY_CONFIG.BALL_START_Y, GRAVITY_CONFIG.GROUND_HEIGHT + radius + 4);
    const maxRows = Math.max(1, Math.floor((height - startY * 2) / spacing) + 1);
    const columnsNeeded = Math.ceil(count / maxRows);
    const compactColumns = Math.floor((width - (radius + 1) * 2) / (radius * 2 + 1)) + 1;

    // Resserrer les colonnes si cela permet de garder tous les logos dans le canvas mobile.
    if (columnsNeeded > columns && columnsNeeded <= compactColumns) {
        columns = columnsNeeded;
        margin = radius + 1;
    }

    const horizontalSpacing = columns > 1
        ? Math.min(GRAVITY_CONFIG.BALL_SPACING, (width - margin * 2) / (columns - 1))
        : 0;

    return Array.from({ length: count }, (_, index) => {
        const row = Math.floor(index / columns);
        const rowCount = Math.min(columns, count - row * columns);

        return {
            x: width / 2 + (index % columns - (rowCount - 1) / 2) * horizontalSpacing,
            y: startY + row * spacing,
        };
    });
}

export function observeGravitySize(render, container, balls, walls) {
    const { Body, Render } = Matter;
    const { ground, roof, wallLeft, wallRight } = walls;

    const observer = new ResizeObserver(() => {
        const width = container.clientWidth;
        const height = container.clientHeight;
        const previousWidth = render.options.width;
        const previousHeight = render.options.height;

        if (!width || !height || (width === previousWidth && height === previousHeight)) return;

        Render.setSize(render, width, height);
        Body.scale(ground, width / previousWidth, 1);
        Body.scale(roof, width / previousWidth, 1);
        Body.scale(wallLeft, 1, height / previousHeight);
        Body.scale(wallRight, 1, height / previousHeight);

        Body.setPosition(ground, { x: width / 2, y: height - GRAVITY_CONFIG.GROUND_HEIGHT / 2 });
        Body.setPosition(roof, { x: width / 2, y: GRAVITY_CONFIG.GROUND_HEIGHT / 2 });
        Body.setPosition(wallLeft, { x: -10, y: height / 2 });
        Body.setPosition(wallRight, { x: width + 10, y: height / 2 });

        // Redisposer les logos pour éviter de les laisser hors du cadre après un redimensionnement.
        const positions = getSkillPositions(width, balls.length, height);
        balls.forEach((ball, index) => {
            Body.setPosition(ball, positions[index]);
            Body.setVelocity(ball, { x: 0, y: 0 });
            Body.setAngularVelocity(ball, 0);
        });
    });

    observer.observe(container);
    return observer;
}
