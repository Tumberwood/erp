<script>

    function location_3d(end_date, id_iwhxxmh){
        const container = document.getElementById('threejs-container');

        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }

        var tooltip_3d = document.getElementById('tooltip_3d');

        var scene = new THREE.Scene();
        scene.background = new THREE.Color(0xf0f0f0);

        var camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 1, 1000);
        camera.position.set(-30, 30, 30);

        var renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        container.appendChild(renderer.domElement);

        // Controls
        var controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.enablePan = true;
        controls.screenSpacePanning = true;
        controls.minDistance = 10;
        controls.maxDistance = 500;
        controls.target.set(10, 0, 30);
        controls.update();

        // Lights
        var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(100, 100, 100);
        scene.add(directionalLight);

        var ambientLight = new THREE.AmbientLight(0x666666);
        scene.add(ambientLight);

        // tooltip_3d & Raycaster
        var raycaster = new THREE.Raycaster();
        var mouse = new THREE.Vector2();
        var interactiveBoxes = [];

        // Floor
        var floorGeometry = new THREE.PlaneGeometry(300, 200);
        var floorMaterial = new THREE.MeshPhongMaterial({ color: 0x6bbb6b });
        var floor = new THREE.Mesh(floorGeometry, floorMaterial);
        floor.rotation.x = -Math.PI / 2;
        scene.add(floor);

        var metalMaterial = new THREE.MeshStandardMaterial({ color: 0x222222, metalness: 0.8, roughness: 0.4 });
        var woodMaterial = new THREE.MeshStandardMaterial({ color: 0xdddddd, metalness: 0.2, roughness: 0.5 });

        var loader = new THREE.FontLoader();
        let font;
        loader.load('https://cdn.jsdelivr.net/npm/three@0.128.0/examples/fonts/helvetiker_regular.typeface.json', loadedFont => {
            font = loadedFont;
            generateRacks();
        });

        function createRackWithSides(x, z, levels, totalBays, depth, rackName, boxDataPerSide) {
            var rackGroup = new THREE.Group();
            var frameThickness = 0.4;
            var frameHeightStep = 3.5;
            var shelfThickness = 0.3;
            var bayWidth = 5;
            var sideWidth = totalBays * bayWidth;
            var rackDepth = depth * 4;
            var rackHeight = (levels) * frameHeightStep;

            var verticalPostGeo = new THREE.BoxGeometry(frameThickness, rackHeight + 0.2, frameThickness);
            for (let b = 0; b <= totalBays; b++) {
                var xOffset = b * bayWidth;
                [0, rackDepth].forEach(d => {
                var postL = new THREE.Mesh(verticalPostGeo, metalMaterial);
                postL.position.set(xOffset, rackHeight / 2, z + d);
                rackGroup.add(postL);

                var postR = new THREE.Mesh(verticalPostGeo, metalMaterial);
                postR.position.set(xOffset, rackHeight / 2, z - d);
                rackGroup.add(postR);
                });
            }

            var barGeo = new THREE.BoxGeometry(bayWidth, frameThickness, frameThickness);
            for (let l = 1; l <= levels; l++) {
                var y = (l - 1) * frameHeightStep;
                for (let b = 0; b < totalBays; b++) {
                var xMid = b * bayWidth + bayWidth / 2;
                [z + rackDepth / 2, z - rackDepth / 2].forEach(posZ => {
                    var bar = new THREE.Mesh(barGeo, metalMaterial);
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
                    var shelfL = new THREE.Mesh(shelfGeo, woodMaterial);
                    shelfL.position.set(xMid, y, z - rackDepth / 2);
                    shelfL.userData.label = labelL;
                    interactiveBoxes.push(shelfL);
                    rackGroup.add(shelfL);

                    // Sisi kanan (R) di z + rackDepth/2
                    var labelR = `${rackName}-${String(b+1).padStart(2,'0')}-${String(l).padStart(2,'0')}-R`;
                    var shelfR = new THREE.Mesh(shelfGeo, woodMaterial);
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

                return new THREE.Color(`rgb(${r},${g},${b})`);
            }

            var placeBoxes = (side, zOffset) => {
                if (!boxDataPerSide[side] || boxDataPerSide[side].length === 0) return;

                boxDataPerSide[side].forEach(boxInfo => {
                    var { nama, is_fill, bay, max_input, level, str } = boxInfo;

                    if (is_fill === 0) return;

                    var bayIndex = (bay || 1) - 1;
                    var xPos = bayIndex * bayWidth + bayWidth / 2;
                    var yPos = ((level || 1) - 1) * frameHeightStep + 1.25;

                    // Hitung ratio is_fill / max_input
                    var ratio = is_fill / max_input;
                    var boxColor = getHeatmapColor(ratio);
                    var boxMaterial = new THREE.MeshStandardMaterial({ color: boxColor });

                    var boxMesh = new THREE.Mesh(boxGeo, boxMaterial);
                    boxMesh.position.set(xPos, yPos, z + zOffset);
                    boxMesh.userData.label = nama + "\nTotal Entry: " + (is_fill ? is_fill : 'Terisi') + '\n\n' + str;
                    interactiveBoxes.push(boxMesh);
                    rackGroup.add(boxMesh);

                    var edges = new THREE.EdgesGeometry(boxGeo);
                    var edgeLines = new THREE.LineSegments(edges, new THREE.LineBasicMaterial({ color: 0x4B2E1D }));
                    edgeLines.position.copy(boxMesh.position);
                    rackGroup.add(edgeLines);
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
                textMesh.position.set(sideWidth / 2 - textWidth / 2, rackHeight + 2, z);
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
            scene.add(rackGroup);
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
            let zOffset = 0;
            var spacing = 30; // jarak antar rack vertikal
            let minZ = Infinity;
            let maxZ = -Infinity;
            let maxSideWidth = 0;
            var bayWidth = 5;

            for (var rackName in rackGrouped) {
                var bayData = rackGrouped[rackName];
                var totalBays = Object.keys(bayData).length;
                var boxData = { L: [], R: [] };
                for (var bay in bayData) {
                boxData.L.push(...bayData[bay].L);
                boxData.R.push(...bayData[bay].R);
                }

                var sideWidth = totalBays * bayWidth;
                if (sideWidth > maxSideWidth) maxSideWidth = sideWidth;

                createRackWithSides(0, zOffset, 4, totalBays, 2, `Rack ${rackName}`, boxData, font);

                if (zOffset < minZ) minZ = zOffset;
                if (zOffset > maxZ) maxZ = zOffset;

                zOffset += spacing;
            }

            // Update floor (karpet)
            var carpetLength = maxZ - minZ + spacing;
            var carpetWidth = maxSideWidth + 10;
            floor.geometry.dispose();
            floor.geometry = new THREE.PlaneGeometry(carpetWidth, carpetLength);
            floor.position.set(carpetWidth / 2 - 2.5, 0, (maxZ + minZ) / 2);
        }

        function setupListeners() {
            window.addEventListener('resize', () => {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });

            window.addEventListener('mousemove', (event) => {
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
            });

            container.addEventListener('dblclick', function(event) {
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
            });
        }

        function animate() {
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        }

        // Panggil ajax dan generate racks
        $.ajax({
            url: "../../models/wms_3d_visual/wms_3d_visual_fn_location_3d.php",
            type: "POST",
            dataType: "json",
            data: {
                end_date: end_date,
                id_iwhxxmh: id_iwhxxmh
            },
            success: function(json) {
                const rs_wloxxmh = json.data.rs_wloxxmh;

                // Cek jika data kosong atau bukan array
                if (!Array.isArray(rs_wloxxmh) || rs_wloxxmh.length === 0) {
                    // console.warn('No rack data returned.');
                    return; // stop di sini
                }

                // Bersihkan data lama jika perlu
                interactiveBoxes.length = 0;
                rackGrouped = {};

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
                console.error('AJAX error:', status, err);
            }
        });
    }
</script>