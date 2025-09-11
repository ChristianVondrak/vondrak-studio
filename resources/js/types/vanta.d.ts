// Declaraciones de tipos para Vanta.js
declare module 'vanta/dist/vanta.globe.min' {
    export interface VantaGlobeConfig {
        el: HTMLElement;
        backgroundColor?: number;
        color?: number;
        color2?: number;
        size?: number;
        mouseControls?: boolean;
        touchControls?: boolean;
        gyroControls?: boolean;
        minHeight?: number;
        minWidth?: number;
        scale?: number;
        scaleMobile?: number;
    }

    export interface VantaEffect {
        destroy(): void;
    }

    export interface VantaGlobeModule {
        GLOBE(config: VantaGlobeConfig): VantaEffect;
    }

    const VANTA: VantaGlobeModule;
    export default VANTA;
}

declare module 'three' {
    const THREE: any;
    export = THREE;
}