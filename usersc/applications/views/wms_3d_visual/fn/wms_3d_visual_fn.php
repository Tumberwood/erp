<script>

    function location_3d(end_date, id_iwhxxmh){
        const container = document.getElementById('threejs-container');

        if (window.wms3dState) {
            cancelAnimationFrame(window.wms3dState.animationFrame);
            window.removeEventListener('resize', window.wms3dState.resizeHandler);
            window.wms3dState.container.removeEventListener('mousemove', window.wms3dState.mouseMoveHandler);
            window.wms3dState.container.removeEventListener('dblclick', window.wms3dState.doubleClickHandler);
            window.wms3dState.container.removeEventListener('mouseleave', window.wms3dState.mouseLeaveHandler);
            window.wms3dState.controls.dispose();
            if (window.wms3dState.resizeObserver) window.wms3dState.resizeObserver.disconnect();
            if (window.wms3dState.request) window.wms3dState.request.abort();
            if (window.wms3dState.scene) {
                window.wms3dState.scene.traverse(function(object) {
                    if (!object.isMesh) return;
                    if (object.geometry) object.geometry.dispose();
                    var materials = Array.isArray(object.material) ? object.material : [object.material];
                    materials.forEach(function(material) {
                        if (!material) return;
                        ['map', 'roughnessMap', 'metalnessMap', 'bumpMap', 'normalMap', 'aoMap'].forEach(function(key) {
                            if (material[key]) material[key].dispose();
                        });
                        material.dispose();
                    });
                });
            }
            window.wms3dState.renderer.dispose();
        }

        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }

        var tooltip_3d = document.getElementById('tooltip_3d');

        var scene = new THREE.Scene();
        scene.background = new THREE.Color(0xdfe5eb);

        var camera = new THREE.PerspectiveCamera(48, container.clientWidth / container.clientHeight, 0.1, 3000);

        var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        renderer.outputEncoding = THREE.sRGBEncoding;
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.05;
        container.appendChild(renderer.domElement);

        // Controls
        var controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.enablePan = true;
        controls.screenSpacePanning = true;
        controls.minDistance = 4;
        controls.maxDistance = 1500;
        controls.target.set(0, 0, 0);
        controls.update();
        window.wms3dState = {
            container: container,
            scene: scene,
            controls: controls,
            renderer: renderer,
            animationFrame: 0,
            resizeHandler: null,
            mouseMoveHandler: null,
            doubleClickHandler: null,
            mouseLeaveHandler: null,
            resizeObserver: null,
            request: null
        };
        var renderState = window.wms3dState;

        // Warehouse lighting with soft, real-time shadows.
        var directionalLight = new THREE.DirectionalLight(0xfff3df, 2.4);
        directionalLight.position.set(40, 70, 35);
        directionalLight.castShadow = true;
        directionalLight.shadow.mapSize.set(2048, 2048);
        directionalLight.shadow.bias = -0.00025;
        directionalLight.shadow.normalBias = 0.025;
        directionalLight.shadow.camera.left = -100;
        directionalLight.shadow.camera.right = 100;
        directionalLight.shadow.camera.top = 100;
        directionalLight.shadow.camera.bottom = -100;
        directionalLight.shadow.camera.near = 1;
        directionalLight.shadow.camera.far = 300;
        scene.add(directionalLight);

        scene.add(new THREE.HemisphereLight(0xe8f2ff, 0x77716a, 1.35));

        // tooltip_3d & Raycaster
        var raycaster = new THREE.Raycaster();
        var mouse = new THREE.Vector2();
        var interactiveBoxes = [];

        function makeCanvasTexture(drawTexture, repeatX, repeatY) {
            var canvas = document.createElement('canvas');
            canvas.width = 512;
            canvas.height = 512;
            drawTexture(canvas.getContext('2d'), canvas.width, canvas.height);
            var texture = new THREE.CanvasTexture(canvas);
            texture.wrapS = texture.wrapT = THREE.RepeatWrapping;
            texture.repeat.set(repeatX || 1, repeatY || 1);
            texture.anisotropy = renderer.capabilities.getMaxAnisotropy();
            texture.encoding = THREE.sRGBEncoding;
            return texture;
        }

        var steelTexture = makeCanvasTexture(function(ctx, width, height) {
            ctx.fillStyle = '#64717d';
            ctx.fillRect(0, 0, width, height);
            for (var i = 0; i < 1100; i++) {
                var shade = Math.floor(75 + Math.random() * 75);
                ctx.fillStyle = 'rgba(' + shade + ',' + (shade + 5) + ',' + (shade + 10) + ',0.12)';
                ctx.fillRect(Math.random() * width, Math.random() * height, 1 + Math.random() * 3, 1);
            }
            ctx.fillStyle = 'rgba(220,230,238,0.18)';
            ctx.fillRect(28, 0, 5, height);
            ctx.fillStyle = 'rgba(15,22,30,0.2)';
            ctx.fillRect(36, 0, 3, height);
        }, 1, 2);

        var cartonTexture = makeCanvasTexture(function(ctx, width, height) {
            ctx.fillStyle = '#e9dfca';
            ctx.fillRect(0, 0, width, height);
            for (var i = 0; i < 4200; i++) {
                var alpha = (0.025 + Math.random() * 0.07).toFixed(2);
                ctx.fillStyle = Math.random() > 0.5 ? 'rgba(92,68,38,' + alpha + ')' : 'rgba(255,255,255,' + alpha + ')';
                var size = 1 + Math.random() * 2;
                ctx.fillRect(Math.random() * width, Math.random() * height, size, size);
            }
            for (var y = 18; y < height; y += 38) {
                ctx.fillStyle = 'rgba(130,101,62,0.10)';
                ctx.fillRect(0, y, width, 2);
                ctx.fillStyle = 'rgba(255,255,255,0.18)';
                ctx.fillRect(0, y + 2, width, 2);
            }
            ctx.fillStyle = 'rgba(198,168,111,0.78)';
            ctx.fillRect(width * 0.46, 0, width * 0.08, height);
            ctx.fillStyle = 'rgba(255,255,255,0.24)';
            ctx.fillRect(width * 0.46, 0, 3, height);
        }, 1, 1);

        var concreteTexture = makeCanvasTexture(function(ctx, width, height) {
            ctx.fillStyle = '#aeb5b9';
            ctx.fillRect(0, 0, width, height);
            for (var i = 0; i < 9000; i++) {
                var gray = Math.floor(95 + Math.random() * 130);
                ctx.fillStyle = 'rgba(' + gray + ',' + gray + ',' + gray + ',0.12)';
                var size = 1 + Math.random() * 2;
                ctx.fillRect(Math.random() * width, Math.random() * height, size, size);
            }
            ctx.strokeStyle = 'rgba(75,84,89,0.16)';
            ctx.lineWidth = 2;
            for (var grid = 0; grid <= width; grid += 128) {
                ctx.beginPath(); ctx.moveTo(grid, 0); ctx.lineTo(grid, height); ctx.stroke();
                ctx.beginPath(); ctx.moveTo(0, grid); ctx.lineTo(width, grid); ctx.stroke();
            }
        }, 5, 5);

        // Concrete warehouse floor
        var floorGeometry = new THREE.PlaneGeometry(300, 200);
        var floorMaterial = new THREE.MeshStandardMaterial({ map: concreteTexture, roughness: 0.92, metalness: 0.02 });
        var floor = new THREE.Mesh(floorGeometry, floorMaterial);
        floor.rotation.x = -Math.PI / 2;
        floor.position.y = -0.08;
        floor.receiveShadow = true;
        scene.add(floor);

        var metalMaterial = new THREE.MeshStandardMaterial({ map: steelTexture, color: 0x56718d, metalness: 0.48, roughness: 0.48 });
        var beamMaterial = new THREE.MeshStandardMaterial({ map: steelTexture, color: 0xffa13b, metalness: 0.3, roughness: 0.52 });
        var shelfMaterial = new THREE.MeshStandardMaterial({ map: steelTexture, color: 0xe1e4e6, metalness: 0.42, roughness: 0.52 });
        var rackGroups = [];
        var rackDataReady = false;

        var loader = new THREE.FontLoader();
        let font;
        loader.load('https://cdn.jsdelivr.net/npm/three@0.128.0/examples/fonts/helvetiker_regular.typeface.json', loadedFont => {
            if (window.wms3dState !== renderState) return;
            font = loadedFont;
            if (rackDataReady) generateRacks();
        });

        function createRackWithSides(x, z, levels, totalBays, depth, rackName, boxDataPerSide) {
            var rackGroup = new THREE.Group();
            var frameThickness = 0.4;
            var frameHeightStep = 3.5;
            var shelfThickness = 0.3;
            var bayWidth = 6; // Lebar rack dari samping
            var sideWidth = totalBays * bayWidth;
            var rackDepth = depth * 2; //Lebar rack dari depan
            var rackHeight = (levels) * frameHeightStep;

            var verticalPostGeo = new THREE.BoxGeometry(frameThickness, rackHeight + 0.2, frameThickness);
            for (let b = 0; b <= totalBays; b++) {
                var xOffset = b * bayWidth;
                [-rackDepth, rackDepth].forEach(postZ => {
                    var post = new THREE.Mesh(verticalPostGeo, metalMaterial);
                    post.position.set(xOffset, rackHeight / 2, z + postZ);
                    rackGroup.add(post);
                });
            }

            var barGeo = new THREE.BoxGeometry(bayWidth, frameThickness, frameThickness);
            for (let l = 1; l <= levels; l++) {
                var y = (l - 1) * frameHeightStep;
                for (let b = 0; b < totalBays; b++) {
                var xMid = b * bayWidth + bayWidth / 2;
                [z + rackDepth / 2, z - rackDepth / 2].forEach(posZ => {
                    var bar = new THREE.Mesh(barGeo, beamMaterial);
                    bar.position.set(xMid, y, posZ);
                    rackGroup.add(bar);
                });
                }
            }

            var shelfGeo = new THREE.BoxGeometry(bayWidth - 0.2, shelfThickness, rackDepth - 0.2);
            for (let l = 1; l <= levels; l++) {
                var y = (l - 1) * frameHeightStep + shelfThickness / 2;
                for (let b = 0; b < totalBays; b++) {
                    var xMid = b * bayWidth + bayWidth / 2;

                    // Sisi kiri (L) di z - rackDepth/2
                    var labelL = `${rackName}-${String(b+1).padStart(2,'0')}-${String(l).padStart(2,'0')}-L`;
                    var shelfL = new THREE.Mesh(shelfGeo, shelfMaterial);
                    shelfL.position.set(xMid, y, z - rackDepth / 2);
                    shelfL.userData.label = labelL;
                    interactiveBoxes.push(shelfL);
                    rackGroup.add(shelfL);

                    // Sisi kanan (R) di z + rackDepth/2
                    var labelR = `${rackName}-${String(b+1).padStart(2,'0')}-${String(l).padStart(2,'0')}-R`;
                    var shelfR = new THREE.Mesh(shelfGeo, shelfMaterial);
                    shelfR.position.set(xMid, y, z + rackDepth / 2);
                    shelfR.userData.label = labelR;
                    interactiveBoxes.push(shelfR);
                    rackGroup.add(shelfR);
                }
            }

            // ------------------ BOX HEATMAP ---------------------//
            var boxGeo = new THREE.BoxGeometry(4.5, 2.5, 3.5);

            function getHeatmapColor(ratio) {
                ratio = Math.min(Math.max(ratio, 0), 1);

                let r, g, b;

                if (ratio < 0.5) {
                    // dari hijau (0,255,0) ke kuning (255,255,0)
                    const t = ratio / 0.5;
                    r = Math.floor(255 * t);
                    g = 255;
                    b = 0;
                } else {
                    // dari kuning (255,255,0) ke merah (255,0,0)
                    const t = (ratio - 0.5) / 0.5;
                    r = 255;
                    g = Math.floor(255 * (1 - t));
                    b = 0;
                }

                return new THREE.Color(`rgb(${r},${g},${b})`).lerp(new THREE.Color(0xffffff), 0.42);
            }

            var placeBoxes = (side, zOffset) => {
                if (!boxDataPerSide[side] || boxDataPerSide[side].length === 0) return;

                boxDataPerSide[side].forEach(boxInfo => {
                    var { nama, is_fill, bay, max_input, level, str } = boxInfo;

                    if (Number(is_fill) <= 0) return;

                    var bayIndex = (bay || 1) - 1;
                    var xPos = bayIndex * bayWidth + bayWidth / 2;
                    var yPos = ((level || 1) - 1) * frameHeightStep + 1.25;

                    // Hitung ratio is_fill / max_input
                    var ratio = Number(max_input) > 0 ? Number(is_fill) / Number(max_input) : 0;
                    var boxColor = getHeatmapColor(ratio);
                    var boxMaterial = new THREE.MeshStandardMaterial({
                        map: cartonTexture,
                        color: boxColor,
                        roughness: 0.88,
                        metalness: 0
                    });

                    var boxMesh = new THREE.Mesh(boxGeo, boxMaterial);
                    boxMesh.position.set(xPos, yPos, z + zOffset);
                    boxMesh.castShadow = true;
                    boxMesh.receiveShadow = true;
                    boxMesh.userData.label = nama + "\nTotal Entry: " + (is_fill ? is_fill : 'Terisi') + '\n\n' + str;
                    interactiveBoxes.push(boxMesh);
                    rackGroup.add(boxMesh);
                });
            };

            placeBoxes("L", -rackDepth / 2); // sisi kiri
            placeBoxes("R", rackDepth / 2);  // sisi kanan

            // var boxGeo = new THREE.BoxGeometry(4.5, 2.5, 3.5);
            // var boxMaterialL = new THREE.MeshStandardMaterial({ color: 0x6b4f2a });
            // var boxMaterialR = new THREE.MeshStandardMaterial({ color: 0x7a5c38 });


            // var placeBoxes = (side, zOffset, material) => {
            //     if (!boxDataPerSide[side] || boxDataPerSide[side].length === 0) return;

            //     boxDataPerSide[side].forEach(boxInfo => {
            //         var { nama, is_fill, bay, level, str } = boxInfo;
            //         // console.log('BOX INFO:', nama, 'is_fill:', is_fill);

            //         if (is_fill === 0) return;

            //         var bayIndex = (bay || 1) - 1;
            //         var xPos = bayIndex * bayWidth + bayWidth / 2;
            //         var yPos = ((level || 1) - 1) * frameHeightStep + 1.25;

            //         var boxMesh = new THREE.Mesh(boxGeo, material);
            //         boxMesh.position.set(xPos, yPos, z + zOffset);
            //         boxMesh.userData.label = nama + "\nTotal Entry: " + (is_fill ? is_fill : 'Terisi') + '\n\n' + str;
            //         // boxMesh.userData.label = nama || 'Terisi';
            //         interactiveBoxes.push(boxMesh);
            //         rackGroup.add(boxMesh);

            //         // Tambahkan garis tepi (outline hitam)
            //         var edges = new THREE.EdgesGeometry(boxGeo);
            //         var edgeLines = new THREE.LineSegments(edges, new THREE.LineBasicMaterial({ color: 0x4B2E1D }));
            //         edgeLines.position.copy(boxMesh.position);
            //         rackGroup.add(edgeLines);
            //     });
            // };

            // placeBoxes("L", -rackDepth / 2, boxMaterialL); // kiri
            // placeBoxes("R", rackDepth / 2, boxMaterialR);  // kanan

            if (font && rackName) {
                var textGeo = new THREE.TextGeometry(rackName, {
                    font: font,
                    size: 2,
                    height: 0.3
                });
                textGeo.computeBoundingBox();
                var textWidth = textGeo.boundingBox.max.x - textGeo.boundingBox.min.x;
                var textMesh = new THREE.Mesh(textGeo, new THREE.MeshStandardMaterial({ color: 0xFF3333 }));
                textMesh.position.set(sideWidth / 2 - textWidth / 2, rackHeight + 2, z - 4);
                textMesh.rotation.y = -Math.PI / 2;
                rackGroup.add(textMesh);
            }
            
            // Buat rangka besi: beberapa batang memanjang (x) dan melintang (z)
            var barThickness = 0.1;
            var barLengthX = sideWidth;
            var barLengthZ = rackDepth * 2 + 0.2;
            var barSpacing = 1.0; // jarak antar batang

            // Bar memanjang sepanjang X (horizontal)
            for (let i = 0; i <= barLengthZ / barSpacing; i++) {
                var barGeo = new THREE.BoxGeometry(barLengthX, 0.15, barThickness);
                var bar = new THREE.Mesh(barGeo, metalMaterial);
                bar.position.set(sideWidth / 2, rackHeight + 0.15, z - barLengthZ/2 + i * barSpacing);
                rackGroup.add(bar);
            }

            // Bar memanjang sepanjang Z (vertikal)
            for (let i = 0; i <= barLengthX / barSpacing; i++) {
                var barGeo = new THREE.BoxGeometry(barThickness, 0.15, barLengthZ);
                var bar = new THREE.Mesh(barGeo, metalMaterial);
                bar.position.set(i * barSpacing, rackHeight + 0.15, z);
                rackGroup.add(bar);
            }

            rackGroup.position.set(x, 0, 0);
            rackGroup.traverse(function(object) {
                if (object.isMesh) {
                    object.castShadow = object !== floor;
                    object.receiveShadow = true;
                }
            });
            scene.add(rackGroup);
            rackGroups.push(rackGroup);
        }
        
        var rawData = [];
        var rackGrouped = {};

        // Asumsi ada scene, camera, renderer, controls, floor, container, tooltip_3d sudah dibuat sebelumnya

        function groupRackData(data) {
            for (var item of data) {
                var rack = item.rack_name;
                var bay = item.bay;
                var side = item.nama.endsWith('-L') ? 'L' : 'R';
                if (!rackGrouped[rack]) rackGrouped[rack] = {};
                if (!rackGrouped[rack][bay]) rackGrouped[rack][bay] = { L: [], R: [] };
                rackGrouped[rack][bay][side].push(item);
            }
        }

        function generateRacks() {
            rackGroups.forEach(function(group) {
                scene.remove(group);
                group.traverse(function(object) {
                    if (object.isMesh) object.geometry.dispose();
                });
            });
            rackGroups = [];
            interactiveBoxes.length = 0;

            let zOffset = 0;
            var spacing = 17; // jarak antar rack
            let minZ = Infinity;
            let maxZ = -Infinity;
            for (var rackName in rackGrouped) {
                var bayData = rackGrouped[rackName];
                var totalBays = Object.keys(bayData).length;
                var boxData = { L: [], R: [] };
                for (var bay in bayData) {
                boxData.L.push(...bayData[bay].L);
                boxData.R.push(...bayData[bay].R);
                }

                createRackWithSides(0, zOffset, 4, totalBays, 2, `Rack ${rackName}`, boxData, font);

                if (zOffset < minZ) minZ = zOffset;
                if (zOffset > maxZ) maxZ = zOffset;

                zOffset += spacing;
            }

            if (!rackGroups.length) return;

            var rackBounds = new THREE.Box3();
            rackGroups.forEach(function(group) { rackBounds.expandByObject(group); });
            var rackCenter = new THREE.Vector3();
            var rackSize = new THREE.Vector3();
            rackBounds.getCenter(rackCenter);
            rackBounds.getSize(rackSize);

            // Concrete slab sized to the actual rack layout.
            var carpetWidth = Math.max(rackSize.x + 18, 24);
            var carpetLength = Math.max(rackSize.z + 22, 28);
            floor.geometry.dispose();
            floor.geometry = new THREE.PlaneGeometry(carpetWidth, carpetLength);
            floor.position.set(rackCenter.x, -0.08, rackCenter.z);

            var radius = Math.max(rackSize.length() * 0.5, 12);
            controls.target.copy(rackCenter);
            camera.near = Math.max(radius / 100, 0.1);
            camera.far = radius * 12;
            camera.updateProjectionMatrix();
            var cameraDistance = radius / Math.sin(THREE.MathUtils.degToRad(camera.fov * 0.5)) * 1.2;
            camera.position.copy(rackCenter).add(new THREE.Vector3(-1.25, 0.82, 1.45).normalize().multiplyScalar(cameraDistance));
            controls.minDistance = Math.max(radius * 0.18, 4);
            controls.maxDistance = cameraDistance * 4;

            directionalLight.position.set(rackCenter.x + radius, rackCenter.y + radius * 1.8, rackCenter.z + radius);
            directionalLight.target.position.copy(rackCenter);
            scene.add(directionalLight.target);
            var shadowExtent = radius * 1.4;
            directionalLight.shadow.camera.left = -shadowExtent;
            directionalLight.shadow.camera.right = shadowExtent;
            directionalLight.shadow.camera.top = shadowExtent;
            directionalLight.shadow.camera.bottom = -shadowExtent;
            directionalLight.shadow.camera.far = radius * 5;
            directionalLight.shadow.camera.updateProjectionMatrix();
            controls.update();
        }

        function setupListeners() {
            var resizeHandler = function() {
                var width = Math.max(container.clientWidth, 1);
                var height = Math.max(container.clientHeight, 1);
                camera.aspect = width / height;
                camera.updateProjectionMatrix();
                renderer.setSize(width, height);
            };
            var mouseMoveHandler = function(event) {
                var rect = container.getBoundingClientRect();
                mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
                mouse.y = - ((event.clientY - rect.top) / rect.height) * 2 + 1;

                raycaster.setFromCamera(mouse, camera);
                var intersects = raycaster.intersectObjects(interactiveBoxes);

                if (intersects.length > 0) {
                    var label = intersects[0].object.userData.label;
                    tooltip_3d.style.display = 'block';
                    tooltip_3d.style.left = (event.clientX - rect.left + 10) + 'px';
                    tooltip_3d.style.top = (event.clientY - rect.top + 10) + 'px';
                    tooltip_3d.innerText = label;
                } else {
                    tooltip_3d.style.display = 'none';
                }
            };

            var doubleClickHandler = function(event) {
                const rect = container.getBoundingClientRect();
                mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
                mouse.y = - ((event.clientY - rect.top) / rect.height) * 2 + 1;

                raycaster.setFromCamera(mouse, camera);
                const intersects = raycaster.intersectObjects(interactiveBoxes, true);

                if (intersects.length > 0) {
                    const point = intersects[0].point;

                    // Lerp kamera dan target ke point
                    const camDir = new THREE.Vector3().subVectors(camera.position, controls.target);
                    const newCamPos = new THREE.Vector3().addVectors(point, camDir.multiplyScalar(0.4));

                    gsap.to(camera.position, {
                        duration: 1,
                        x: newCamPos.x,
                        y: newCamPos.y,
                        z: newCamPos.z,
                        onUpdate: () => {
                            camera.lookAt(point);
                            controls.update();
                        }
                    });

                    gsap.to(controls.target, {
                        duration: 1,
                        x: point.x,
                        y: point.y,
                        z: point.z
                    });
                }
            };
            var mouseLeaveHandler = function() { tooltip_3d.style.display = 'none'; };

            window.addEventListener('resize', resizeHandler);
            container.addEventListener('mousemove', mouseMoveHandler);
            container.addEventListener('dblclick', doubleClickHandler);
            container.addEventListener('mouseleave', mouseLeaveHandler);
            window.wms3dState.resizeHandler = resizeHandler;
            window.wms3dState.mouseMoveHandler = mouseMoveHandler;
            window.wms3dState.doubleClickHandler = doubleClickHandler;
            window.wms3dState.mouseLeaveHandler = mouseLeaveHandler;
            if (window.ResizeObserver) {
                window.wms3dState.resizeObserver = new ResizeObserver(resizeHandler);
                window.wms3dState.resizeObserver.observe(container);
            }
            resizeHandler();
        }

        function animate() {
            window.wms3dState.animationFrame = requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }

        // Panggil ajax dan generate racks
        renderState.request = $.ajax({
            url: "../../models/wms_3d_visual/wms_3d_visual_fn_location_3d.php",
            type: "POST",
            dataType: "json",
            data: {
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function(json) {
                if (window.wms3dState !== renderState) return;
                const rs_wloxxmh = json.data.rs_wloxxmh;

                // Cek jika data kosong atau bukan array
                if (!Array.isArray(rs_wloxxmh) || rs_wloxxmh.length === 0) {
                    // console.warn('No rack data returned.');
                    return; // stop di sini
                }

                // Bersihkan data lama jika perlu
                interactiveBoxes.length = 0;
                rackGrouped = {};
                rackDataReady = true;

                // Group data
                groupRackData(rs_wloxxmh);

                // Generate racks
                generateRacks();

                // Setup listener (mouse, resize, dsb)
                setupListeners();

                // Start animation
                animate();
            },
            error: function(xhr, status, err) {
                if (status === 'abort' || window.wms3dState !== renderState) return;
                console.error('AJAX error:', status, err);
            }
        });
    }
</script>
