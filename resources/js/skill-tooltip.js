import Matter from "matter-js";

export function attachSkillTooltip(render, container, balls) {
    const { Events, Query } = Matter;
    const canvas = render.canvas;
    const tooltip = document.createElement("div");
    tooltip.className = "gravity-tooltip";
    tooltip.setAttribute("role", "tooltip");
    tooltip.hidden = true;
    container.append(tooltip);

    canvas.setAttribute("role", "img");
    canvas.setAttribute("aria-label", `Technologies : ${balls.map((ball) => ball.label).join(", ")}`);

    let pointer = null;

    function hideTooltip() {
        tooltip.hidden = true;
        canvas.style.cursor = "";
    }

    function clearPointer() {
        pointer = null;
        hideTooltip();
    }

    function trackPointer(event) {
        pointer = { x: event.clientX, y: event.clientY };
    }

    canvas.addEventListener("pointermove", trackPointer);
    canvas.addEventListener("pointerdown", trackPointer);
    canvas.addEventListener("pointerleave", clearPointer);
    canvas.addEventListener("pointercancel", clearPointer);
    window.addEventListener("blur", clearPointer);
    window.addEventListener("keydown", (event) => {
        if (event.key === "Escape") clearPointer();
    });

    // Refaire la détection à chaque image : les billes bougent même sans mouvement de souris.
    Events.on(render, "afterRender", () => {
        if (!pointer) return;

        const bounds = canvas.getBoundingClientRect();
        if (!bounds.width || !bounds.height) return hideTooltip();

        const scaleX = bounds.width / render.options.width;
        const scaleY = bounds.height / render.options.height;
        const point = {
            x: (pointer.x - bounds.left) / scaleX,
            y: (pointer.y - bounds.top) / scaleY,
        };
        const ball = Query.point(balls, point).at(-1);

        if (!ball) return hideTooltip();

        if (tooltip.textContent !== ball.label) tooltip.textContent = ball.label;
        tooltip.hidden = false;
        canvas.style.cursor = render.mouse.button === 0 ? "grabbing" : "grab";

        const containerBounds = container.getBoundingClientRect();
        const centerX = bounds.left - containerBounds.left + ball.position.x * scaleX;
        const centerY = bounds.top - containerBounds.top + ball.position.y * scaleY;
        const radius = ball.circleRadius * scaleY;
        const gap = 10;
        const padding = 8;
        const maxLeft = Math.max(padding, container.clientWidth - tooltip.offsetWidth - padding);
        const maxTop = Math.max(padding, container.clientHeight - tooltip.offsetHeight - padding);
        let top = centerY - radius - tooltip.offsetHeight - gap;

        if (top < padding) top = centerY + radius + gap;

        tooltip.style.left = `${Math.max(padding, Math.min(centerX - tooltip.offsetWidth / 2, maxLeft))}px`;
        tooltip.style.top = `${Math.max(padding, Math.min(top, maxTop))}px`;
    });
}
